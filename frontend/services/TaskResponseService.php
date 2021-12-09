<?php

namespace frontend\services;

use app\models\Notifications;
use frontend\models\forms\ResponseForm;
use frontend\models\Responses;
use frontend\models\Tasks;
use frontend\models\Users;
use Yii;

class TaskResponseService
{
    private ResponseForm $form;

    /**
     * @param array $data
     * @param int $taskId
     * @return void|null
     */
    public function execute(array $data, int $taskId): ?int
    {
        $this->form = new ResponseForm();
        if (!$this->form->load(Yii::$app->request->post()) || !$this->form->validate()) {
            return null;
        }

        $task = Tasks::findOne($taskId);

        $response = new Responses();
        $response->executor_id = Yii::$app->user->identity->getId();
        $response->task_id = $task->id;
        $response->price = $this->form->price;
        $response->description = $this->form->description;
        $response->save();

        $executor = Users::findOne($response->executor_id);
        $executor->is_executor = 1;
        $executor->save();

        $notice = new Notifications();
        $notice->title = Notifications::TITLE_NEW_RESPONSE;
        $notice->icon = Notifications::ICONS_SELECT_EXECUTOR;
        $notice->description = Tasks::findOne($taskId)->name;
        $notice->task_id = $task->id;
        $notice->user_id = $task->user_id;
        $notice->save();

        return 1;
    }

    /**
     * @return ResponseForm
     */
    public function getForm(): ResponseForm
    {
        return $this->form;
    }
}