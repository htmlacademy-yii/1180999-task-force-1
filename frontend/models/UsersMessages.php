<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_messages".
 *
 * @property int $id
 * @property string $dt_add
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $message
 * @property int $task_id
 * @property int $is_read
 *
 * @property Users $recipient
 * @property Users $sender
 * @property Tasks $task
 */
class UsersMessages extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['sender_id', 'recipient_id', 'message', 'task_id'], 'required'],
            [['dt_add'], 'safe'],
            [['sender_id', 'recipient_id', 'task_id', 'is_read'], 'integer'],
            [['message'], 'string'],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['recipient_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'sender_id' => 'Sender ID',
            'recipient_id' => 'Recipient ID',
            'message' => 'Message',
            'task_id' => 'Task ID',
            'is_read' => 'Is Read',
        ];
    }

    /**
     * Gets query for [[Recipient]].
     *
     * @return ActiveQuery
     */
    public function getRecipient(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'recipient_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return ActiveQuery
     */
    public function getSender(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'sender_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return ActiveQuery
     */
    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->dt_add = date('Y-m-d H:i:s');
        }
        return true;
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'dt_add' => function () {
                return \Yii::$app->formatter->format($this->dt_add, 'relativeTime');
            },
            'sender_id',
            'recipient_id',
            'message',
            'sender' => function () {
                return $this->sender->name;
            },
            'is_mine' => function () {
                if ($this->sender_id === \Yii::$app->user->getId()) {
                    return 1;
                }
                return 0;
            }
        ];
    }
}
