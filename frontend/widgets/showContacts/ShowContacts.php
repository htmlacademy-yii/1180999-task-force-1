<?php

namespace frontend\widgets\showContacts;

use frontend\models\Tasks;
use taskforce\Task;
use Yii;
use yii\base\Widget;

class ShowContacts extends Widget
{
    public $user;

    public function run()
    {
        return $this->render('contacts', [
            'count' => $this->getCountActiveTasks(),
            'user' => $this->user
        ]);
    }

    public function getCountActiveTasks()
    {
        return Tasks::find()->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['executor_id' => $this->user->id])
            ->andWhere(['status' => Task::STATUS_IN_WORK])
            ->count();
    }
}