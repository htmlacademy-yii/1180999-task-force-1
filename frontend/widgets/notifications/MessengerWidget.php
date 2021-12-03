<?php

namespace frontend\widgets\notifications;

use app\models\Notifications;
use frontend\models\Tasks;
use frontend\models\Users;
use taskforce\Task;
use Yii;
use yii\base\Widget;

class MessengerWidget extends Widget
{
    public int $task_id;

    /**
     * @return string
     */
    public function run()
    {
        $task = Tasks::findOne($this->task_id);
            return $this->render('messages', [
                'notifications' => $this->getInfo(),
                'task' => $task
            ]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    private function getInfo()
    {
        return Notifications::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->andWhere(['is_read' => 0])
            ->andWhere(['task_id' => $this->task_id])
            ->all();
    }
}
