<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Cities;
use frontend\models\Files;
use frontend\models\forms\AccountForm;
use frontend\models\Users;
use frontend\models\UsersCategories;
use frontend\models\UsersFiles;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class AccountController extends SecuredController
{
    public function actionIndex()
    {
        $user = Users::findOne(\Yii::$app->user->getId());
        $userForm = new AccountForm();
        $userFiles = UsersFiles::find()
            ->where(['user_id' => $user->id]);
        $categories = Categories::find()
            ->select(['name', 'id'])
            ->indexBy('id')->column();
        $userCategories = UsersCategories::find()->select('category_id')
            ->where(['user_id' => $user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $userFiles,
            'pagination' => [
                'pageSize' => 6
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

//        Записываем id категорий в форму с полем специализаций
        $userForm->category_ids = $userCategories->indexBy('category_id')->column();

//        Назначаем пользователя мастером, если у него выбрана хотя бы одна специализация
        if ($userCategories->count() < 1) {
            $user->is_executor = 0;
        } else {
            $user->is_executor = 1;
        }
        $user->save();

        if (\Yii::$app->request->isPost) {

            if ($userForm->load(\Yii::$app->request->post()) && $userForm->validate()) {

//                Если специализации выбраны, то удаляем старые категории и вносим новые
                if ($userForm->category_ids) {
                    if (count($userForm->category_ids) != $userCategories->count()) {

                        foreach ($user->categories as $category) {
                            $category->delete();
                        }

                        foreach ($userForm->category_ids as $category_id) {
                            $userCategories = new UsersCategories();
                            $userCategories->user_id = $user->id;
                            $userCategories->category_id = (int)$category_id;
                            $userCategories->save();
                        }
                    }
//                    Иначе, если чекбоксы категорий очмщены, то удаляем текущие категории
                } else {
                    foreach ($user->categories as $category) {
                        $category->delete();
                    }
                }

//                Загрузка фото для портфолио
                $files = UploadedFile::getInstances($userForm, 'images');
                if (!empty($files)) {
                    foreach ($files as $uplFile) {
                        $file = new Files();
                        $fileName = uniqid();
                        $file->name = "$uplFile->baseName.$uplFile->extension";
                        $file->path = '/uploads/' . $fileName . '.' . $uplFile->extension;
                        $file->save();
                        $uplFile->saveAs("uploads/$fileName.$uplFile->extension");
                        $userFiles = new UsersFiles();
                        $userFiles->file_id = $file->id;
                        $userFiles->user_id = $user->id;
                        $userFiles->save();
                    }
                }

//                Загрузка аватарки
                $avatar = UploadedFile::getInstance($userForm, 'avatar');
                if (!empty($avatar)) {
                    $file = new Files();
                    $fileName = uniqid();
                    $file->name = "$avatar->baseName.$avatar->extension";
                    $file->path = '/uploads/' . $fileName . '.' . $avatar->extension;
                    $file->save();
                    $avatar->saveAs("uploads/$fileName.$avatar->extension");
                    $user->avatar_file_id = $file->id;
                }

                if ($userForm->city) {
                    $user->city = Cities::findOne(['name' => $userForm->city])->id;
                }
                if ($userForm->password) {
                    $user->password = \Yii::$app->getSecurity()->generatePasswordHash($userForm->passwordRepeat);
                    \Yii::$app->session->setFlash('userPassword');
                }

                $user->email = $userForm->email;
                $user->birthday = $userForm->birthday;
                $user->about_me = $userForm->aboutMe;
                $user->phone = $userForm->phone;
                $user->skype = $userForm->skype;
                $user->other_contacts = $userForm->otherContacts;
                $user->notification_new_message = (int)$userForm->notification_new_message;
                $user->notification_new_review = (int)$userForm->notification_new_review;
                $user->notification_task_action = (int)$userForm->notification_task_action;
                $user->show_contacts = (int)$userForm->show_contacts;
                $user->hide_profile = (int)$userForm->hide_profile;

                $user->save();
                \Yii::$app->session->setFlash('changeMessage');
                return $this->redirect(['account/index']);
            }

        }

        return $this->render('index', [
            'user' => $user,
            'userForm' => $userForm,
            'dataProvider' => $dataProvider,
            'categories' => $categories
        ]);
    }
}