<?php

namespace frontend\services;

use frontend\models\forms\CompletionForm;
use frontend\models\Reviews;
use frontend\models\Tasks;
use frontend\services\mailer\MailerService;
use taskforce\Task;
use Yii;

class TaskCompletionService
{
    private CompletionForm $form;

    public function execute(Tasks $task): ?int
    {
        $this->form = new CompletionForm();

        if (!$this->form->load(\Yii::$app->request->post()) || !$this->form->validate()) {
            return null;
        }

        switch ($this->form->completeness) {
            case 0:
                $task->status = Task::STATUS_SUCCESS;
                break;
            case 1:
                $task->status = Task::STATUS_FAIL;
        }
        if ($task->save()) {
            if ($task->executor->notification_task_action === 1) {
                $service = new NoticeService();
                $service->run($service::ACTION_CLOSE_TASK, $task->executor_id, $task->id);

                $mailer = new MailerService();
                $mailer->send($mailer::END_MESSAGE, $task, $task->executor->email);
            }
        }

        if ($this->form->description != null || Yii::$app->request->post('rating') != null) {
            $review = new Reviews();
            $review->task_id = $task->id;
            $review->user_id = $task->user_id;
            $review->executor_id = $task->executor_id;
            $review->text = $this->form->description;
            $review->score = Yii::$app->request->post('rating');
            if ($review->save()) {
                if ($review->executor->notification_new_review === 1) {
                    $service = new NoticeService();
                    $service->run($service::ACTION_REVIEW, $task->executor_id, $task->id);

                    $mailer = new MailerService();
                    $mailer->send($mailer::REVIEW_MESSAGE, $task, $task->executor->email);
                }
            }
        }

        return 1;
    }

    /**
     * @return CompletionForm
     */
    public function getForm(): CompletionForm
    {
        return $this->form;
    }
}