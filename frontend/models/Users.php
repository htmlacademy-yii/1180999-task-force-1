<?php

namespace frontend\models;

use app\models\Bookmarks;
use Yii;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $is_executor
 * @property string $dt_add
 * @property string|null $last_active_time
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $contacts
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $other_contacts
 * @property string|null $birthday
 * @property string|null $about_me
 * @property int $notification_new_message
 * @property int $notification_task_action
 * @property int $hide_profile
 * @property int|null $notification_new_review
 * @property int|null $failed_count
 * @property int $show_contacts
 * @property int $city_id
 * @property int|null $avatar_file_id
 *
 * @property UsersCategories[] $categories
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property Reviews[] $reviews0
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property Files $avatarFile
 * @property Cities $city
 * @property UsersFiles[] $usersFiles
 * @property UsersMessages[] $usersMessages
 * @property UsersMessages[] $usersMessages0
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_executor', 'notification_new_message', 'notification_task_action', 'notification_new_review', 'hide_profile', 'failed_count', 'show_contacts', 'city_id', 'avatar_file_id'], 'integer'],
            [['dt_add', 'name', 'email', 'password', 'city_id'], 'required'],
            [['dt_add', 'last_active_time', 'birthday'], 'safe'],
            [['about_me'], 'string'],
            [['name', 'email', 'password', 'contacts', 'phone', 'skype', 'other_contacts'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['avatar_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['avatar_file_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_executor' => 'Is Executor',
            'dt_add' => 'Dt Add',
            'last_active_time' => 'Last Active Time',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'contacts' => 'Contacts',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'other_contacts' => 'Other Contacts',
            'birthday' => 'Birthday',
            'about_me' => 'About Me',
            'notification_new_message' => 'Notification New Message',
            'notification_task_action' => 'Notification Task Action',
            'hide_profile' => 'Hide Profile',
            'failed_count' => 'Failed Count',
            'show_contacts' => 'Show Contacts',
            'city_id' => 'City ID',
            'avatar_file_id' => 'Avatar File ID',
        ];
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|Reviews[]
     */
    public function getReviewsByExecuted()
    {
        return $this->hasMany(Reviews::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewsByCreated()
    {
        return $this->hasMany(Reviews::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[AvatarFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatarFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar_file_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[UsersFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFiles()
    {
        return $this->hasMany(UsersFiles::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UsersMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersMessages()
    {
        return $this->hasMany(UsersMessages::className(), ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[UsersMessages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersMessages0()
    {
        return $this->hasMany(UsersMessages::className(), ['sender_id' => 'id']);
    }

    /**
     * Получения списка специализаций пользователя
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(UsersCategories::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBookmarks(): ActiveQuery
    {
        return $this->hasMany(Bookmarks::class, ['favorite_id' => 'id']);
    }

    public function getBookmarks0()
    {
        return $this->hasMany(Bookmarks::class, ['follower_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function calcRatingScore()
    {
        $countReviews = 0;

        $sum = 0;
        foreach ($this->reviewsByExecuted as $review) {
            $sum = $sum + $review->score;
            $countReviews++;
        }
        if ($countReviews === 0) {
            return 0;
        }

        return $sum/count($this->reviewsByExecuted);
    }


    /**
     * @return bool
     */
    public function beforeValidate(): bool
    {
        parent::beforeValidate();
        if (!$this->dt_add) {
            $this->dt_add = date('Y-m-d H:i:s');
        }
        return true;
    }

    /**
     * @return string[]
     */
    public function fields()
    {
        return [
            'id', 'name', 'email'
        ];
    }

    /**
     * @param $value
     */
    public function setCity($value)
    {
        $this->city_id = $value;
    }


}
