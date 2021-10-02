<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property string|null $dt_add
 * @property int $executor_id
 * @property int $task_id
 * @property string|null $description
 * @property int $price
 * @property string|null $refuse
 *
 * @property Users $executor
 * @property Tasks $task
 */
class Responses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['executor_id', 'task_id', 'price'], 'required'],
            [['executor_id', 'task_id', 'price'], 'integer'],
            [['description'], 'string'],
            [['refuse'], 'string', 'max' => 255],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'executor_id' => 'Executor ID',
            'task_id' => 'Task ID',
            'description' => 'Description',
            'price' => 'Price',
            'refuse' => 'Refuse',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * @param bool $insert
     * @return bool|void
     */
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->dt_add = date('Y-m-d H:i:s');
        }
        return true;
    }
}
