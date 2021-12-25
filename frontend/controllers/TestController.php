<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}