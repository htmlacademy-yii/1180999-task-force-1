<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $icon
 * @property int $is_read
 * @property int $user_id
 * @property int $task_id
 *
 */

class Notifications extends ActiveRecord
{
    public const TITLE_NEW_MESSAGE = 'Новое сообщение в чате';
    public const TITLE_SELECT_EXECUTOR = 'Вас выбрали исполнителем для';
    public const TITLE_NEW_RESPONSE = 'Новый отклик для';
    public const TITLE_NEW_REVIEW = 'Новый отзыв';
    public const TITLE_REFUSE_RESPONSE = 'Ваш отклик отклонен в';
    public const TITLE_CLOSE_TASK = 'Завершено задание';
    public const TITLE_TASK_REFUSAL = 'Исполнитель отказался от выполнения в';
    public const TITLE_TASK_LOST = 'Срок исполнения истек в';

    public const ICONS_NEW_MESSAGE = '--message';
    public const ICONS_SELECT_EXECUTOR = '--executor';
    public const ICONS_CLOSE_TASK = '--close';
    public const ICONS_REFUSE_RESPONSE = '--refuse-response';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'icon', 'user_id', 'task_id'], 'required'],
            [['is_read', 'user_id', 'task_id'], 'integer'],
            [['title', 'description', 'icon'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'icon' => 'Icon',
            'is_read' => 'Is Read',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

}
