<?php

namespace app\models;

use Yii;

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

class Notifications extends \yii\db\ActiveRecord
{
    public const TITLE = [
        'newMessage' => 'Новое сообщение в чате',
        'selectExecutor' => 'Вас выбрали исполнителем для',
        'newResponse' => 'Новый отклик для',
        'closeTask' => 'Завершено задание'
    ];

    public const ICONS = [
        'newMessage' => '--message',
        'selectExecutor' => '--executor',
        'closeTask' => '--close'
    ];

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
