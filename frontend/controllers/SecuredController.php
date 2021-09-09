<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class SecuredController extends Controller
{
    /**
     * Глобальный фильтр запрета для анонимных пользователей
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],

                    ]
                ]
            ]
        ];
    }
}
