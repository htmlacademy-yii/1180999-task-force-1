<?php

namespace frontend\controllers;

use frontend\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SecuredController extends Controller
{
    public function behaviors(): array
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

    /**
     * Отслеживание последней активности пользователя
     */
    public function init()
    {
        parent::init();

        if (!Yii::$app->user->isGuest) {
            $user = Users::findOne(Yii::$app->user->id);
            $user->last_active_time = date('Y-m-d H:i:s');
            $user->save(false, ["last_active_time"]);
        }
    }
}
