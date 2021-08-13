<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_files".
 *
 * @property int $id
 * @property int $user_id
 * @property int $file_id
 *
 * @property Files $file
 * @property Users $user
 */
class UsersFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'file_id'], 'required'],
            [['user_id', 'file_id'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'id']],
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
            'user_id' => 'User ID',
            'file_id' => 'File ID',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'file_id']);
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
}
