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
$user = Users::findOne(1);

$userCategories = UsersCategories::find()->select('category_id')
    ->where(['user_id' => $user->id]);
$cat_ids = $userCategories->indexBy('category_id')->column();

if (count($cat_ids) > 0) {
    print count($cat_ids);
}

print $userCategories->count();
