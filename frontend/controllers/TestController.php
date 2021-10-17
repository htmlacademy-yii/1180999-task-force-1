<?php

namespace frontend\controllers;

use frontend\models\forms\SingUpForm;
use yii\web\Controller;


class TestController extends Controller
{
    public function actionIndex()
    {
        $model = new SingUpForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            var_dump($model);
        }

        return $this->render('index',
            compact('model')
        );
    }
}
