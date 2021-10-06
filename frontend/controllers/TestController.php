<?php

namespace frontend\controllers;

use yii\base\Controller;

class TestController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }
}