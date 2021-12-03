<?php

namespace frontend\widgets\notifications;

use app\models\Notifications;
use frontend\models\Users;
use yii\base\Widget;

class NotificationsWidget extends Widget
{
    public int $user_id;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('notifications', [
            'notifications' => $this->getNotifications()
        ]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    private function getNotifications()
    {
        return Notifications::find()->where(['user_id' => $this->user_id, 'is_read' => 0])->all();
    }
}



