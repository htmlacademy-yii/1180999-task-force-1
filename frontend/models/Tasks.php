<?php

namespace frontend\models;

use taskforce\Task;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $dt_add
 * @property string|null $deadline
 * @property int $user_id
 * @property int|null $executor_id
 * @property int $category_id
 * @property int|null $city_id
 * @property string|null $status
 * @property string $name
 * @property string $description
 * @property string $address
 * @property int|null $cost
 *
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property Categories $category
 * @property Cities $city
 * @property Users $executor
 * @property Users $user
 * @property TasksFiles[] $tasksFiles
 * @property UsersMessages[] $usersMessages
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'name', 'description'], 'required'],
            [['dt_add', 'deadline'], 'safe'],
            [['user_id', 'executor_id', 'category_id', 'city_id', 'cost'], 'integer'],
            [['description', 'address'], 'string'],
            [['status', 'name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'deadline' => 'Deadline',
            'user_id' => 'User ID',
            'executor_id' => 'Executor ID',
            'category_id' => 'Category ID',
            'city_id' => 'Location',
            'address' => 'Address',
            'status' => 'Status',
            'name' => 'Name',
            'description' => 'Description',
            'cost' => 'Cost',
        ];
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TasksFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFiles()
    {
        return $this->hasMany(TasksFiles::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[UsersMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersMessages()
    {
        return $this->hasMany(UsersMessages::className(), ['task_id' => 'id']);
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
            $this->status = Task::STATUS_NEW;
        }
        return true;
    }
}
