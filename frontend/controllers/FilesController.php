<?php

namespace frontend\controllers;

use frontend\models\Files;
use frontend\models\Users;
use frontend\models\UsersFiles;
use Yii;
use yii\helpers\Url;
use yii\web\Response;

class FilesController extends SecuredController
{
    /**
     * Удаление файла пользователя
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id): Response
    {
        $file = UsersFiles::findOne($id);
        if ($file && $file->user_id === Yii::$app->user->getId()) {
            $file->delete();
            $file->file->delete();
            if (file_exists($file->file->path)) {
                unlink($file->file->path);
            }
        }
        return $this->redirect(Url::to(['account/index']));
    }

    /**
     * Удаление фото пользователя
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionAvatarDelete($id): Response
    {
        $user = Users::findOne($id);

        if ($user->id === Yii::$app->user->getId()) {
            $file = Files::findOne($user->avatar_file_id);
            $user->avatar_file_id = null;
            $user->save();
            $file->delete();
        }
        return $this->redirect(Url::to(['account/index']));
    }
}