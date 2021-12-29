<?php

namespace frontend\models;

use taskforce\Task;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 * @property string $location
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
class Tasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'category_id', 'name', 'description'], 'required'],
            [['dt_add', 'deadline'], 'safe'],
            [['user_id', 'executor_id', 'category_id', 'city_id', 'cost'], 'integer'],
            [['description', 'address', 'location'], 'string'],
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
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'deadline' => 'Deadline',
            'user_id' => 'User ID',
            'executor_id' => 'Executor ID',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'address' => 'Address',
            'location' => 'Location',
            'status' => 'Status',
            'name' => 'Name',
            'description' => 'Description',
            'cost' => 'Cost',
        ];
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return ActiveQuery
     */
    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Responses::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return ActiveQuery
     */
    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Location]].
     *
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
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
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TasksFiles]].
     *
     * @return ActiveQuery
     */
    public function getTasksFiles(): ActiveQuery
    {
        return $this->hasMany(TasksFiles::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[UsersMessages]].
     *
     * @return ActiveQuery
     */
    public function getUsersMessages(): ActiveQuery
    {
        return $this->hasMany(UsersMessages::className(), ['task_id' => 'id']);
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
            $this->status = Task::STATUS_NEW;
        }
        return true;
    }
}
