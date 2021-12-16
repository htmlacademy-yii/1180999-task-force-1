<?php

namespace frontend\controllers;

use app\models\Auth;
use frontend\models\Cities;
use frontend\models\Files;
use frontend\models\Tasks;
use frontend\services\api\GeoCoderApi;
use Yii;
use frontend\models\Users;
use yii\db\Exception;
use frontend\models\forms\LoginForm;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Инициализация layouts/landing
     */
    public function init()
    {
        parent::init();
        $this->layout = '@app/views/layouts/landing';

    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $loginForm = new LoginForm();
        $lastTasks = Tasks::find()->orderBy('dt_add DESC')->limit(4)->all();

        if (\Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());
            if ($loginForm->validate()) {
                \Yii::$app->user->login(Users::findOne(['email' => $loginForm->email]));
                return $this->redirect('tasks');
            }
        }

        return $this->render('landing', [
            'model' => $loginForm,
            'tasks' => $lastTasks
        ]);
    }


    /**
     * Вывод пользователя из сессии
     */
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        $this->goHome();
    }

    /**
     * @param $client
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // авторизация
                $user = $auth->user;
                Yii::$app->user->login(Users::findIdentity($user->id));

            } else { // регистрация
                if (isset($attributes['email']) && Users::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не связан. Для начала войдите на сайт использую электронную почту, для того, что бы связать её.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(20);
                    $getCity = new GeoCoderApi();
                    $data = $getCity->getData($attributes['city']['title']);
                    $searchCity = Cities::find()->where(['name' => $data['street']])->one();
                    if ($searchCity) {
                        $city_id = $searchCity->id;
                    } else {
                        $city = new Cities();
                            $city->name = $data['street'];
                            $city->latitude =  $data['points']['latitude'];
                            $city->longitude = $data['points']['longitude'];
                        if ($city->save()) {
                            $city_id = $city->id;
                        } else {
                            throw new Exception('Не удалось добавить адрес');
                        }
                    }

                    $birthday = date('Y-m-d', strtotime($attributes['bdate']));

                    $user = new Users([
                        'name' => $attributes['first_name'],
                        'email' => $attributes['email'],
                        'city_id' => $city_id,
                        'password' => $password,
                        'birthday' => $birthday,
                        'about_me' => $attributes['about'],
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();

                    $avatar = new Files();
                    $avatar->name = uniqid() . '_user_ava';
                    $avatar->path = $attributes['photo_max'];
                    if ($avatar->save()) {
                        $user->avatar_file_id = $avatar->id;
                    }

                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login(Users::findIdentity($user->id));
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }

                }
            }
        } else {
            if (!$auth) {
                $auth = new Auth([
                    'user_id' => Yii::$app->user->identity->getId(),
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }

        Yii::$app->session->setFlash('auth', 'Вы успешно авторизированны');
        return $this->redirect(['tasks/index']);
    }

    /**
     * @return array[]
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
}
