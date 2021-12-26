<?php

namespace frontend\services;

use app\models\Notifications;
use frontend\models\Tasks;

/**
 * Сервис доставки уведомлений
 * Для отправки, необходимо указать действие, задачу и получателя
 */
class NoticeService
{
    public const ACTION_NEW_RESPONSE = 0;
    public const ACTION_REFUSE_RESPONSE = 1;
    public const ACTION_ACCEPT_RESPONSE = 2;
    public const ACTION_REFUSAL_OF_TASK = 3;
    public const ACTION_MESSAGE = 4;
    public const ACTION_REVIEW = 5;
    public const ACTION_CLOSE_TASK = 6;

    /**
     * @param string $action Название дейстия
     * @param int $user_id Получатель уведолмления
     * @param int $task_id ID задания
     */
    public function run(string $action,int $user_id, int $task_id)
    {
        $task = Tasks::findOne($task_id);
        $notice = new Notifications();
        $notice->description = $task->name;
        $notice->task_id = $task_id;
        $notice->user_id = $user_id;
        
        switch ($action) {
            case self::ACTION_NEW_RESPONSE:
                $notice->title = Notifications::TITLE_NEW_RESPONSE;
                $notice->icon = Notifications::ICONS_SELECT_EXECUTOR;
                break;
            case self::ACTION_ACCEPT_RESPONSE:
                $notice->title = Notifications::TITLE_SELECT_EXECUTOR;
                $notice->icon = Notifications::ICONS_SELECT_EXECUTOR;
                break;
            case self::ACTION_REFUSE_RESPONSE:
                $notice->title = Notifications::TITLE_REFUSE_RESPONSE;
                $notice->icon = Notifications::ICONS_REFUSE_RESPONSE;
                break;
            case self::ACTION_REFUSAL_OF_TASK:
                $notice->title = Notifications::TITLE_TASK_REFUSAL;
                $notice->icon = Notifications::ICONS_REFUSE_RESPONSE;
                break;
            case self::ACTION_MESSAGE:
                $notice->title = Notifications::TITLE_NEW_MESSAGE;
                $notice->icon = Notifications::ICONS_NEW_MESSAGE;
                break;
            case self::ACTION_REVIEW:
                $notice->title = Notifications::TITLE_NEW_REVIEW;
                $notice->icon = Notifications::ICONS_SELECT_EXECUTOR;
                break;
            case self::ACTION_CLOSE_TASK:
                $notice->title = Notifications::TITLE_CLOSE_TASK;
                $notice->icon = Notifications::ICONS_CLOSE_TASK;
        }
        
        $notice->save();
    }
}