<?php

/**
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 * @var Notifications $notification
 */

use app\models\Notifications;
use yii\helpers\Url;
use yii\web\Controller;

$user = \frontend\models\Users::findOne(1);

$countReviews = 0;
$sum = 0;
$newSum = [];

foreach ($reviews = \frontend\models\Reviews::find()->where(['executor_id' => 1])->all() as $item) {
        if ($item->score != null) {
            $newSum[] = $item->score;
        }
    $countReviews++;
}

if ($countReviews === 0) {
    return 0;
}



print array_sum($newSum) / count($newSum);