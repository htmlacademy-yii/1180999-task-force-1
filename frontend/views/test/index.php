<?php
/**
 * @var SingUpForm $model
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 */

use frontend\models\Categories;
use frontend\models\forms\SingUpForm;
use frontend\models\Users;
use frontend\models\UsersCategories;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


print Yii::$app->security->generatePasswordHash('123');
print '<hr>';
$user = Users::findOne(2);

