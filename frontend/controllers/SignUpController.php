<?php

namespace frontend\controllers;

use frontend\models\Cities;
use frontend\models\forms\SingUpForm;
use frontend\models\Users;
use Yii;
use yii\web\Controller;

/**
 * Контроллер формы регистрации
 * Class SignUpController
 * @package frontend\controllers
 */
class SignUpController extends Controller
{
    public function actionIndex()
    {
        $model = new SingUpForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new Users();
            $user->dt_add = date('Y-m-d h-i-s');
            $user->name = $model->name;
            $user->email = $model->email;
            $user->city_id = $model->city;
            $user->password = $model->password;
            $user->save();
            $this->goHome();

        } else {
            return $this->render('index', [
                'model' => $model
            ]);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

}
