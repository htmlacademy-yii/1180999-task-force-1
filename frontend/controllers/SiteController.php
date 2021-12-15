<?php

namespace frontend\controllers;

use app\models\Auth;
use frontend\models\forms\SingUpForm;
use frontend\models\Tasks;
use Yii;
use frontend\models\Users;
use yii\base\Exception;
use yii\console\Response;
use yii\filters\AccessControl;
use frontend\models\forms\LoginForm;
use yii\helpers\Url;
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
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'onAuthSuccess','login'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['logout', 'onAuthSuccess','login','index'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(Url::to(['tasks/index']));
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
     * @param $client
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
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
                    $password = Yii::$app->security->generateRandomString(8);
                    $user = new Users([
                        'name' => $attributes['login'],
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
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
        } else { // Пользователь уже зарегистрирован
            if (!$auth) { // добавляем внешний сервис аутентификации
                $auth = new Auth([
                    'user_id' => Yii::$app->user->identity->getId(),
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }


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
