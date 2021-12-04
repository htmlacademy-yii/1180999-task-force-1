<?php

/**
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 * @var Notifications $notification
 */

use app\models\Notifications;
use frontend\models\Users;
use yii\helpers\Url;
use yii\web\Controller;

$user = \frontend\models\Users::findOne(1);

print $user->calcRatingScore();

