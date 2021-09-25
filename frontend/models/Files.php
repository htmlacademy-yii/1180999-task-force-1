<?php

namespace frontend\models;

use Yii;

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
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'name'], 'required'],
            [['path', 'name'], 'string', 'max' => 255],
            [['path'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFiles()
    {
        return $this->hasMany(TasksFiles::className(), ['file_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['avatar_file_id' => 'id']);
    }

    /**
     * Gets query for [[UsersFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFiles()
    {
        return $this->hasMany(UsersFiles::className(), ['file_id' => 'id']);
    }
}
