<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Users;

class UsersController extends Controller
{
    /**
     * Функция формирует объект с данными исполнителей
     * @return string
     */
    public function actionIndex(): string
    {
        $users = Users::find()->all();

        return $this->render(
            'users',
            ['users' => $users]
        );
    }

}