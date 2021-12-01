<?php
/**
 * @var SingUpForm $model
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 * @var $bookmark Bookmarks
 */

use app\models\Bookmarks;
use frontend\models\Categories;
use frontend\models\forms\SingUpForm;
use frontend\models\Users;
use frontend\models\UsersCategories;
use taskforce\Task;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

print Yii::$app->security->generatePasswordHash('123');
print '<hr>';


$users = Users::find();
$dataProvider = new ActiveDataProvider([
    'query' => $users,
    'pagination' => [
        'pageSize' => 5
    ]
]);
$users->leftJoin('tasks', 'tasks.executor_id = users.id')
    ->andWhere(['not', ['status' => [Task::STATUS_FAIL, Task::STATUS_SUCCESS]]])

?>

<?= \yii\grid\GridView::widget(['dataProvider' => $dataProvider]); ?>
