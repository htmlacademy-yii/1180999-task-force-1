<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\Users;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\forms\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends SecuredController
{

    public function init()
    {
        parent::init();
        $this->layout = '@app/views/layouts/landing';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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

        if (\Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());
            if ($loginForm->validate()) {
                \Yii::$app->user->login(Users::findOne(['email' => $loginForm->email]));
                return $this->redirect('tasks');
            }
        }

        return $this->render('landing', [
            'model' => $loginForm
        ]);
    }

    /**
     * @return bool|\yii\web\Response
     */
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->goHome();
        }
        return $this->goHome();
    }

    /**
     *
     */
    public function actionError()
    {
        if (Yii::$app->response->statusCode === 404) {
            $this->goHome();
        }

        if (Yii::$app->response->statusCode === 403) {
            $this->redirect('tasks');
        }

    }
}
