<?php
/**
 * @var SingUpForm $model
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 */

use frontend\models\forms\SingUpForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

print strtotime($task->deadline) < time() ? 'Просрочено' : 'Активно';
