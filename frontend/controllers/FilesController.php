<?php

namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\UsersFiles;
use yii\helpers\Url;

class FilesController extends SecuredController
{
    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $file = UsersFiles::findOne($id);
        if ($file && $file->user_id === \Yii::$app->user->getId()) {
            $file->delete();
            $file->file->delete();
            if (file_exists($file->file->path)) {
                unlink($file->file->path);
            }
        }
        return $this->redirect(Url::to(['account/index']));
    }
}