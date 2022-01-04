<?php

namespace frontend\services;

use app\models\Auth;
use frontend\models\Cities;
use frontend\models\Files;
use frontend\models\Users;
use frontend\services\api\GeoCoderApi;
use Yii;
use yii\db\Exception;
use yii\authclient\clients\VKontakte;

/**
 * User registration Service
 */
class UserRegistrationService
{
    public array $attributes;
    public VKontakte $client;

    /**
     * @param array $attributes UserData from API
     * @param VKontakte $client Auth_Client
     */
    public function __construct(array $attributes, VKontakte $client)
    {
        $this->attributes = $attributes;
        $this->client = $client;
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function execute(): bool
    {
        if (!isset($this->attributes['email']) && Users::find()->where(['email' => $this->attributes['email']])->exists()) {
            return false;
        } else {
            $password = Yii::$app->security->generateRandomString(20);
            $getCity = new GeoCoderApi();
            $data = $getCity->getData($this->attributes['city']['title']);
            $searchCity = Cities::find()->where(['like', 'name', $data['street']])->one();
            if ($searchCity) {
                $city_id = $searchCity->id;
            } else {
                $city = new Cities();
                $city->name = $data['street'];
                $city->latitude = $data['points']['latitude'];
                $city->longitude = $data['points']['longitude'];
                if ($city->save()) {
                    $city_id = $city->id;
                } else {
                    throw new Exception('Не удалось добавить адрес');
                }
            }

            $birthday = date('Y-m-d', strtotime($this->attributes['bdate']));

            $user = new Users([
                'name' => $this->attributes['first_name'],
                'email' => $this->attributes['email'],
                'city_id' => $city_id,
                'password' => $password,
                'birthday' => $birthday,
                'about_me' => $this->attributes['about'],
            ]);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            $transaction = $user->getDb()->beginTransaction();

            $avatar = new Files();
            $avatar->name = uniqid() . '_user_ava';
            $avatar->path = $this->attributes['photo_max'];
            if ($avatar->save()) {
                $user->avatar_file_id = $avatar->id;
            }

            if ($user->save()) {
                $auth = new Auth([
                    'user_id' => $user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$this->attributes['id'],
                ]);
                if ($auth->save()) {
                    $transaction->commit();
                    Yii::$app->user->login(Users::findIdentity($user->id));
                } else {
                    print_r($auth->getErrors());
                }
            } else {
                return false;
            }
        }
    return true;
    }
}