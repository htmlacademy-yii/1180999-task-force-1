<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $path
 * @property string $name
 *
 * @property TasksFiles[] $tasksFiles
 * @property Users[] $users
 * @property UsersFiles[] $usersFiles
 */
class Files extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['path', 'name'], 'required'],
            [['path', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[TasksFiles]].
     *
     * @return ActiveQuery
     */
    public function getTasksFiles(): ActiveQuery
    {
        return $this->hasMany(TasksFiles::className(), ['file_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(Users::className(), ['avatar_file_id' => 'id']);
    }

    /**
     * Gets query for [[UsersFiles]].
     *
     * @return ActiveQuery
     */
    public function getUsersFiles(): ActiveQuery
    {
        return $this->hasMany(UsersFiles::className(), ['file_id' => 'id']);
    }
}
