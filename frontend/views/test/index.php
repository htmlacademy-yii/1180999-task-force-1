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

$user = \frontend\models\Users::findOne(1);
print $user->name;
$user->name = 'NewUser';
$user->save();
print $user->name;