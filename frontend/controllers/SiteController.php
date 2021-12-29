<?php

namespace frontend\controllers;

use app\models\Auth;
use frontend\models\Tasks;
use frontend\services\UserRegistrationService;
use Yii;
use frontend\models\Users;
use yii\db\Exception;
use frontend\models\forms\LoginForm;
use yii\web\Controller;
use yii\web\Response;

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
     * @return string|Response
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
     * @return Response
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function onAuthSuccess($client): Response
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
                $regService = new UserRegistrationService($attributes, $client);
                $regService->execute();
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
