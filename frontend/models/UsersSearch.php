<?php

namespace frontend\models;

use app\models\Bookmarks;
use frontend\models\forms\UserFilterForm;
use frontend\widgets\bookmark\Bookmark;
use taskforce\Task;
use Yii;
use yii\data\ActiveDataProvider;

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
 * @property string $phone
 * @property string $skype
 * @property string|null $other_contacts
 * @property string $birthday
 * @property string $about_me
 * @property int $notification_new_message
 * @property int $notification_task_action
 * @property int|null $failed_count
 * @property int $show_contacts
 * @property int $city_id
 * @property int|null $avatar_file_id
 *
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property Files $avatarFile
 * @property Cities $city
 * @property UsersFiles[] $usersFiles
 * @property UsersMessages[] $usersMessages
 * @property UsersMessages[] $usersMessages0
 */
class UsersSearch extends \yii\db\ActiveRecord
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
            [['is_executor', 'notification_new_message', 'notification_task_action', 'failed_count', 'show_contacts', 'city_id', 'avatar_file_id'], 'integer'],
            [['dt_add', 'name', 'email', 'password', 'phone', 'skype', 'birthday', 'about_me', 'city_id'], 'required'],
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
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['executor_id' => 'id']);
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
     * @param UserFilterForm $modelForm
     * @return ActiveDataProvider
     */
    public function search(UserFilterForm $modelForm): ActiveDataProvider
    {
        $query = Users::find()->where(['users.is_executor' => 1]);
        $bookmarks = Bookmarks::find()
            ->select('favorite_id')
            ->where(['follower_id' => Yii::$app->user->id])
            ->indexBy('favorite_id')->column();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if ($modelForm->category_ids) {
            $query->leftJoin('users_categories', 'users_categories.user_id = users.id')
                ->andFilterWhere([
                    'users_categories.category_id' => $modelForm->category_ids
                ]);
        }

        if ($modelForm->online) {
            $query->andWhere(['>', 'last_active_time', date('Y-m-d H:i:s', strtotime('-30 minutes'))]);
        }

        if ($modelForm->favorite) {

            $query->andWhere(['users.id' => $bookmarks]);
        }

        if ($modelForm->nameSearch) {
            $query->andFilterWhere(['like', 'name', $modelForm->nameSearch]);
        }

        if ($modelForm->isFree) {
            $query->leftJoin('tasks', 'tasks.executor_id = users.id')
                ->andWhere(['tasks.executor_id' => null]);
        }

        if ($modelForm->review) {
            $query->leftJoin('reviews', 'reviews.executor_id = users.id')
                ->andWhere(['not',['reviews.executor_id' => null]]);
        }

        return $dataProvider;
    }
}
