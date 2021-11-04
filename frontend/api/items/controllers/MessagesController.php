<?php

namespace frontend\api\items\controllers;

use frontend\models\Tasks;
use frontend\models\UsersMessages;
use Yii;
use yii\web\ForbiddenHttpException;

class MessagesController extends BaseApiController
{
    public $modelClass = UsersMessages::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        return $actions;
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function actionIndex(int $task_id = null)
    {
        $request = Yii::$app->request;
        if ($request->isGet) {
            if (!$task_id) {
                throw new ForbiddenHttpException();
            }
            return UsersMessages::find()->where(['task_id' => $task_id])->all();
        }
    }

    /**
     * @return UsersMessages
     */
    public function actionCreate(): UsersMessages
    {
        $message_body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $message = new UsersMessages();
        $message->sender_id = Yii::$app->user->getId();;
        $message->recipient_id = Tasks::findOne($message_body['task_id'])->user_id;
        $message->task_id = $message_body['task_id'];
        $message->message = $message_body['message'];
        $message->save();

        Yii::$app->getResponse()->setStatusCode(201);
        return $message;
    }
}