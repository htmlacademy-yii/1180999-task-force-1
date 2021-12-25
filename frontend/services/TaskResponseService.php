<?php

namespace frontend\services;

use app\models\Notifications;
use frontend\models\forms\ResponseForm;
use frontend\models\Responses;
use frontend\models\Tasks;
use frontend\models\Users;
use frontend\services\mailer\MailerService;
use Yii;

class TaskResponseService
{
    private ResponseForm $form;

    /**
     * @param array $data
     * @param Tasks $task
     * @return void|null
     */
    public function execute(array $data, Tasks $task): ?int
    {
        $this->form = new ResponseForm();
        if (!$this->form->load($data) || !$this->form->validate()) {
            return null;
        }

        $response = new Responses();
        $response->executor_id = Yii::$app->user->identity->getId();
        $response->task_id = $task->id;
        $response->price = $this->form->price;
        $response->description = $this->form->description;
        $response->save();

        $executor = Users::findOne($response->executor_id);
        $executor->is_executor = 1;
        $executor->save();

        if ($task->user->notification_task_action === 1) {
            $service = new NoticeService();
            $service->run($service::ACTION_NEW_RESPONSE, $task->user_id, $task->id);

            $mailer = new MailerService();
            $mailer->send($mailer::RESPONSE_MESSAGE, $task, $task->user->email);
        }

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