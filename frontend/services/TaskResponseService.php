<?php

namespace frontend\services;

use frontend\models\forms\ResponseForm;
use frontend\models\Responses;
use frontend\models\Users;
use Yii;

class TaskResponseService
{
    private ResponseForm $form;

    public function execute(array $data, int $taskId): ?int
    {
        $this->form = new ResponseForm();
        if (!$this->form->load(Yii::$app->request->post()) || !$this->form->validate()) {
            return null;
        }

        $response = new Responses();
        $response->executor_id = Yii::$app->user->identity->getId();
        $response->task_id = $taskId;
        $response->price = $this->form->price;
        $response->description = $this->form->description;
        $response->save();

        $executor = Users::findOne($response->executor_id);
        $executor->is_executor = 1;
        $executor->save();

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