<?php

namespace frontend\controllers;

use frontend\models\Cities;
use frontend\models\forms\SingUpForm;
use frontend\models\Users;
use frontend\services\api\GeoCoderApi;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Контроллер регистрации пользователей
 * После проверки введенных данных авторизует и перенаправляет на главную страницу
 * Class SignUpController
 * @package frontend\controllers
 */
class SignUpController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect('tasks');
        }

        $model = new SingUpForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = new Users();
            $user->name = $model->name;
            $user->email = $model->email;
            $user->city_id = $model->getCityId();
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->save();

            if (!$user->save()) {
                throw new Exception('Не удалось создать пользователя');
            }

            Yii::$app->user->login(Users::findIdentity($user->id));
            $this->goHome();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
