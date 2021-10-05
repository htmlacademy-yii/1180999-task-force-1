<?php

namespace frontend\services;

use frontend\models\forms\CompletionForm;
use frontend\models\Reviews;
use frontend\models\Tasks;
use taskforce\Task;
use Yii;

class TaskCompletionService
{
    private CompletionForm $form;

    public function execute(array $data, Tasks $task): ?int
    {
        $this->form = new CompletionForm();

        if (!$this->form->load(Yii::$app->request->post()) || !$this->form->validate()) {
            return null;
        }

        switch ($this->form->completeness) {
            case 0:
                $task->status = Task::STATUS_SUCCESS;
                break;
            case 1:
                $task->status = Task::STATUS_FAIL;
        }

        $task->save();

        $review = new Reviews();
        $review->task_id = $task->id;
        $review->user_id = $task->user_id;
        $review->executor_id = $task->executor_id;
        $review->text = $this->form->description;
        $review->score = Yii::$app->request->post('rating');
        $review->save();

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