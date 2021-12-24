<?php

namespace frontend\services;

use Yii;
use yii\db\ActiveQuery;
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
     * @return int|null Если все прошло успешно возвращает 1, иначе NULL
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function execute(): ?int
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
            if ($this->userForm->category_ids) {
                $this->setCategories();
            }
            if ($this->userForm->city) {
                $this->user->city = Cities::findOne(['name' => $this->userForm->city])->id;
            }
            if ($this->userForm->password) {
                $this->user->password = Yii::$app->getSecurity()->generatePasswordHash($this->userForm->passwordRepeat);
                Yii::$app->session->setFlash('userPassword');
            }

            return $this->update();
        }

        return null;
    }

    /**
     * Функция обновления данных профиля
     * @return int|null В случе успеха возвращает 1
     */
    private function update(): ?int
    {
        $this->user->email = $this->userForm->email;
        $this->user->birthday = $this->userForm->birthday;
        $this->user->about_me = $this->userForm->aboutMe;
        $this->user->phone = $this->userForm->phone;
        $this->user->skype = $this->userForm->skype;
        $this->user->other_contacts = $this->userForm->otherContacts;
        $this->user->notification_new_message = (int)$this->userForm->notification_new_message;
        $this->user->notification_new_review = (int)$this->userForm->notification_new_review;
        $this->user->notification_task_action = (int)$this->userForm->notification_task_action;
        $this->user->show_contacts = (int)$this->userForm->show_contacts;
        $this->user->hide_profile = (int)$this->userForm->hide_profile;
        if ($this->user->save()) {
            return 1;
        }
        return null;
    }

    /**
     * Функция обнолвения специализаций пользователя
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function setCategories()
    {
        if (count($this->userForm->category_ids) != $this->usersCategories->count()) {
            foreach ($this->user->categories as $category) {
                $category->delete();
            }
            foreach ($this->userForm->category_ids as $category_id) {
                $usersCategories = new UsersCategories();
                $usersCategories->user_id = $this->user->id;
                $usersCategories->category_id = (int)$category_id;
                $usersCategories->save();
            }
        } else {
            foreach ($this->user->categories as $category) {
                $category->delete();
            }
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