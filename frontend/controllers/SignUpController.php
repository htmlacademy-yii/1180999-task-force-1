<?php

namespace frontend\controllers;

use frontend\models\forms\SingUpForm;
use frontend\models\Users;
use frontend\services\mailer\WelcomeService;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Контроллер регистрации пользователей
 * После проверки введенных данных авторизует и перенаправляет на главную страницу
 * Class SignUpController
 * @package frontend\controllers
 */
class SignUpController extends Controller
{
    public function behaviors(): array
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
     * @throws Exception
     */
    public function actionIndex(): string
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect('tasks');
        }
        $model = new SingUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new Users();
            $user->name = Html::encode($model->name);
            $user->email = $model->email;
            $user->city_id = $model->getCityId();
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            if ($user->save()) {
                $mailer = new WelcomeService();
                $mailer->send($model);
            }
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
