<?php

namespace frontend\controllers;

use app\models\Notifications;
use frontend\models\Users;
use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}