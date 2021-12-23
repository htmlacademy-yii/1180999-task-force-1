<?php

namespace frontend\controllers;

use app\models\Notifications;

use Yii;

class EventsController extends SecuredController
{
    /**
     * Отмечает все уведомления как прочитанные
     */
    public function actionIndex()
    {
        $notifications = Notifications::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['and', ['is_read' => 0]])
            ->all();

        foreach ($notifications as $notification) {
            $notification->is_read = 1;
            $notification->save();
        }
    }
}