<?php


namespace frontend\controllers;

use yii\web\Controller;

class TestController extends Controller
{
    /**
     * Вывод тестовой страницы
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}