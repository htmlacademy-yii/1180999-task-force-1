<?php

namespace frontend\services;

use app\models\Notifications;
use frontend\models\forms\ResponseForm;
use frontend\models\Responses;
use frontend\models\Tasks;
use frontend\models\Users;
use taskforce\Task;
use Yii;

class TaskTimeService
{
    public $tasks;

    public function execute()
    {

        /**
         * @var $task Tasks
         */

        foreach ($this->tasks->all() as $task) {
            if (strtotime($task->deadline) < time()) {
                $task->status = Task::STATUS_HIDDEN;
                $task->save();

                if ($task->user->notification_task_action === 1) {
                    $noticeUser = new Notifications();
                    $noticeUser->title = Notifications::TITLE_TASK_LOST;
                    $noticeUser->description = $task->name;
                    $noticeUser->task_id = $task->id;
                    $noticeUser->user_id = $task->user_id;
                    $noticeUser->icon = Notifications::ICONS_REFUSE_RESPONSE;
                    $noticeUser->save();
                }

                if ($task->executor && $task->executor->notification_task_action === 1) {
                    $noticeExecutor = new Notifications();
                    $noticeExecutor->title = Notifications::TITLE_TASK_LOST;
                    $noticeExecutor->description = $task->name;
                    $noticeExecutor->task_id = $task->id;
                    $noticeExecutor->user_id = $task->executor_id;
                    $noticeUser->icon = Notifications::ICONS_REFUSE_RESPONSE;
                    $noticeExecutor->save();
                }
            }
        }

    }

}