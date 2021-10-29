<?php

namespace frontend\api\items\controllers;

use frontend\models\Tasks;
use frontend\models\UsersMessages;

class MessagesController extends BaseApiController
{
    public $modelClass = UsersMessages::class;
    public array $allowedActions = ['index'];
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return $actions;
    }

    public function actionIndex(int $task_id = null)
    {
        if (\Yii::$app->request->isGet) {
            return UsersMessages::find()->where(['task_id' => $task_id])->all();
        }

        if (\Yii::$app->request->isPost) {
            $messageBody = json_decode(\Yii::$app->getRequest()->getRawBody(), true);

            $message = new UsersMessages();
            $message->dt_add = date('Y-m-d H:i:s');
            $message->sender_id = \Yii::$app->user->identity->getId();
            $message->recipient_id = Tasks::findOne($messageBody['task_id'])->user->getId();
            $message->message = $messageBody['message'];
            $message->task_id = $messageBody['task_id'];
            $message->is_read = false;
            $message->save();

            \Yii::$app->getResponse()->setStatusCode(201);
            return $message;
        }

        return null;
    }

}
