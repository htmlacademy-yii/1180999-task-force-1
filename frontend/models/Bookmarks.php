<?php

namespace app\models;

use frontend\models\Users;
use Yii;

/**
 * This is the model class for table "bookmarks".
 *
 * @property int $id
 * @property int $follower_id
 * @property int $favorite_id
 *
 * @property Users $favorite
 * @property Users $follower
 */
class Bookmarks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookmarks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['follower_id', 'favorite_id'], 'required'],
            [['follower_id', 'favorite_id'], 'integer'],
            [['favorite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['favorite_id' => 'id']],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['follower_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follower_id' => 'Follower ID',
            'favorite_id' => 'Favorite ID',
        ];
    }

    /**
     * Gets query for [[Favorite]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorite()
    {
        return $this->hasOne(Users::className(), ['id' => 'favorite_id']);
    }

    /**
     * Gets query for [[Follower]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne(Users::className(), ['id' => 'follower_id']);
    }
}
