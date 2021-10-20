<?php

namespace frontend\controllers;

use frontend\models\Tasks;
use Yii;
use frontend\models\Users;
use yii\console\Response;
use yii\filters\AccessControl;
use frontend\models\forms\LoginForm;

/**
 * Site controller
 */
class SiteController extends SecuredController
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
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['tasks/index']);
                },
            ]
        ];
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
