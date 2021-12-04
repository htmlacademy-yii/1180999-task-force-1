<?php

/**
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 * @var Notifications $notification
 */

use app\models\Notifications;
use frontend\models\Files;
use frontend\models\Users;
use yii\helpers\Url;
use yii\web\Controller;

$user = \frontend\models\Users::findOne(14);

if ($user->id === \Yii::$app->user->getId()) {

    $avatarFile = Files::findOne($user->avatar_file_id);
    if (file_exists($avatarFile->path)) {
        unlink($avatarFile->path);
    }
    $avatarFile->delete();

//    $user->avatar_file_id = null;
//    $user->save();
}

