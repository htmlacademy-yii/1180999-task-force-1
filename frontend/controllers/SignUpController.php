<?php

namespace frontend\controllers;

use frontend\models\Cities;
use frontend\models\forms\SingUpForm;
use frontend\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Контроллер формы регистрации
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
        $model = new SingUpForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new Users();
            $user->dt_add = date('Y-m-d h-i-s');
            $user->name = $model->name;
            $user->email = $model->email;
            $user->city_id = $model->city;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->save();
            $this->goHome();

        }
            return $this->render('index', [
                'model' => $model
            ]);
    }
}
