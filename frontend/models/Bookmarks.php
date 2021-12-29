<?php

namespace app\models;

use frontend\models\Users;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Bookmarks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'bookmarks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getFavorite(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'favorite_id']);
    }

    /**
     * Gets query for [[Follower]].
     *
     * @return ActiveQuery
     */
    public function getFollower(): ActiveQuery
    {
        return $this->hasOne(Users::className(), ['id' => 'follower_id']);
    }
}
