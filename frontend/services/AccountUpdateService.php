<?php

namespace frontend\services;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\web\UploadedFile;
use frontend\models\Users;
use frontend\models\Cities;
use frontend\models\UsersFiles;
use frontend\models\UsersCategories;
use frontend\models\forms\AccountForm;

class AccountUpdateService
{
    private Users $user;
    private ActiveQuery $usersCategories;
    private AccountForm $userForm;

    /**
     * Сервис редактирования профиля пользователя
     * @param Users $user Данные пользователя
     * @param ActiveQuery $usersCategories Специализации
     * @param AccountForm $userForm Форма настроек аккаунта
     */
    public function __construct(Users $user, ActiveQuery $usersCategories, AccountForm $userForm)
    {
        $this->user = $user;
        $this->usersCategories = $usersCategories;
        $this->userForm = $userForm;
    }

    /**
     * Функция инициализирует процесс обвноления данных и загрузки файлов
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function execute(): bool
    {
        if ($this->userForm->load(Yii::$app->request->post()) && $this->userForm->validate()) {
            $files = UploadedFile::getInstances($this->userForm, 'images');
            $avatar = UploadedFile::getInstance($this->userForm, 'avatar');

            if ($files) {
                $this->uploadUserFiles($files);
            }
            if ($avatar) {
                $this->uploadAvatar($avatar);
            }

            if (empty($this->userForm->category_ids)) {
                foreach ($this->user->categories as $category) {
                    $category->delete();
                }
            } else {
                $this->setCategories();
            }

            if ($this->userForm->city) {
                $city = Cities::findOne(['name' => $this->userForm->city]);
                if ($city) {
                    $this->user->city = $city->id;
                }
            }
            if ($this->userForm->password) {
                $this->user->password = Yii::$app->getSecurity()->generatePasswordHash($this->userForm->passwordRepeat);
                Yii::$app->session->setFlash('userPassword');
            }

            return $this->update();
        }

        return false;
    }

    /**
     * Функция обновления данных профиля
     */
    private function update(): bool
    {
        $this->user->email = Html::encode($this->userForm->email);
        $this->user->birthday = $this->userForm->birthday;
        $this->user->about_me = Html::encode($this->userForm->aboutMe);
        $this->user->phone = $this->userForm->phone;
        $this->user->skype = Html::encode($this->userForm->skype);
        $this->user->other_contacts = Html::encode($this->userForm->otherContacts);
        $this->user->notification_new_message = (int)$this->userForm->notification_new_message;
        $this->user->notification_new_review = (int)$this->userForm->notification_new_review;
        $this->user->notification_task_action = (int)$this->userForm->notification_task_action;
        $this->user->show_contacts = (int)$this->userForm->show_contacts;
        $this->user->hide_profile = (int)$this->userForm->hide_profile;
        if ($this->user->save()) {
            return true;
        }
        return false;
    }

    /**
     * Функция обнолвения специализаций пользователя
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function setCategories()
    {
        $categories = $this->usersCategories->asArray()->all();
        $newCategories = array_diff_assoc($this->userForm->category_ids, $categories);
        foreach ($this->user->categories as $category) {
            $category->delete();
        }
        foreach ($newCategories as $category_id) {
            $usersCategories = new UsersCategories();
            $usersCategories->user_id = $this->user->id;
            $usersCategories->category_id = (int)$category_id;
            $usersCategories->save();
        }
    }

    /**
     * Функция загрузки файлов пользователя
     * @param $files
     */
    private function uploadUserFiles($files)
    {
        foreach ($files as $uploadFile) {
            $service = new FileUploadService();
            $fileID = $service->upload($uploadFile);

            $userFiles = new UsersFiles();
            $userFiles->file_id = $fileID;
            $userFiles->user_id = $this->user->id;
            $userFiles->save();
        }
    }

    /**
     * Функция смены фото профиля
     * @param $avatar
     */
    private function uploadAvatar($avatar)
    {
        $service = new FileUploadService();
        $this->user->avatar_file_id = $service->upload($avatar);
    }
}