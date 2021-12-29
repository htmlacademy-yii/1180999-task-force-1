<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string|null $dt_add
 * @property int $user_id
 * @property int $executor_id
 * @property int $task_id
 * @property int|null $score
 * @property string|null $text
 *
 * @property Users $executor
 * @property Tasks $task
 * @property Users $user
 */
class Reviews extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['dt_add'], 'safe'],
            [['user_id', 'executor_id', 'task_id'], 'required'],
            [['user_id', 'executor_id', 'task_id', 'score'], 'integer'],
            [['text'], 'string'],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'executor_id' => 'Executor ID',
            'task_id' => 'Task ID',
            'score' => 'Score',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return ActiveQuery
     */
    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
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
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
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
}
