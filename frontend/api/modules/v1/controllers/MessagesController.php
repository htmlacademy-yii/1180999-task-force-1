<?php

namespace frontend\api\modules\v1\controllers;

use app\models\Notifications;
use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\UsersMessages;
use frontend\services\mailer\MailerService;
use frontend\services\NoticeService;
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

        $taskInfo = Tasks::findOne($message_body['task_id']);
        $authorId = $taskInfo->user_id;
        $executorId = $taskInfo->executor_id;
        $currentUserId = Yii::$app->user->getId();

        switch ($currentUserId) {
            case $authorId:
                $message->recipient_id = $executorId;
                break;
            case $executorId:
                $message->recipient_id = $authorId;
        }

        $message->sender_id = $currentUserId;
        $message->task_id = $message_body['task_id'];
        $message->message = $message_body['message'];

        if ($message->save()) {
            if ($message->recipient->notification_new_message === 1) {
                $service = new NoticeService();
                $service->run(NoticeService::ACTION_MESSAGE, $message->recipient_id, $taskInfo->id);

                $mailer = new MailerService();
                $mailer->send($mailer::CHAT_MESSAGE, $taskInfo, $message->recipient->email);
            }
        }

        Yii::$app->getResponse()->setStatusCode(201);
        return $message;
    }
}
