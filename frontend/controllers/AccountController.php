<?php

namespace frontend\controllers;

use frontend\models\Cities;
use frontend\models\Files;
use frontend\models\forms\AccountForm;
use frontend\models\Users;
use frontend\models\UsersFiles;
use http\Url;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\UploadedFile;

class AccountController extends SecuredController
{
    public function actionIndex()
    {
        $user = Users::findOne(\Yii::$app->user->getId());
        $userForm = new AccountForm();
        $userFiles = UsersFiles::find()
            ->where(['user_id' => $user->id])->limit(6);

        $dataProvider = new ActiveDataProvider([
            'query' => $userFiles,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);


        if (\Yii::$app->request->isPost) {

            if ($userForm->load(\Yii::$app->request->post()) && $userForm->validate()) {
                print $user->name;
                $files = UploadedFile::getInstances($userForm, 'images');
                if (!empty($files)) {
                    foreach ($files as $uplFile) {
                        $file = new Files();
                        $fileName = uniqid();
                        $file->name = "$uplFile->baseName.$uplFile->extension";
                        $file->path = 'uploads/' . $fileName . '.' . $uplFile->extension;
                        $file->save();
                        $uplFile->saveAs("uploads/$fileName.$uplFile->extension");
                        $userFiles = new UsersFiles();
                        $userFiles->file_id = $file->id;
                        $userFiles->user_id = $user->id;
                        $userFiles->save();
                    }
                }

                if (isset($userForm->city)) {
                    $user->city = Cities::findOne(['name' => $userForm->city])->id;
                }
                if (isset($userForm->password)) {
                    $user->password = \Yii::$app->getSecurity()->generatePasswordHash($userForm->passwordRepeat);
                }

                $user->email = $userForm->email;
                $user->birthday = $userForm->birthday;
                $user->about_me = $userForm->aboutMe;
                $user->phone = $userForm->phone;
                $user->skype = $userForm->skype;
                $user->other_contacts = $userForm->otherContacts;
                $user->notification_new_message = (int) $userForm->notification_new_message;
                $user->notification_new_review = (int) $userForm->notification_new_review;
                $user->notification_task_action = (int) $userForm->notification_task_action;
                $user->show_contacts = (int) $userForm->show_contacts;
                $user->hide_profile = (int) $userForm->hide_profile;
                $user->save();

                return $this->redirect(['account/index']);
            }

        }

        return $this->render('index', [
            'user' => $user,
            'userForm' => $userForm,
            'dataProvider' => $dataProvider
        ]);
    }
}