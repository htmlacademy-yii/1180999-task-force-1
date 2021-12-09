<?php

/**
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 * @var Notifications $notification
 */

use app\models\Notifications;
use frontend\models\Files;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Tasks;
use frontend\models\Users;
use frontend\services\TaskTimeService;
use taskforce\Task;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;use yii\helpers\Url;
use yii\web\Controller;
use yii\widgets\ListView;

$query = Tasks::find();
$timeService = new TaskTimeService;
$timeService->tasks = $query->where(['not', ['status' => Task::STATUS_FAIL ]])->all();
$timeService->execute();

//        if ($task->deadline) {
//            if (strtotime($task->deadline) < time()) {
//                $task->status = Task::STATUS_HIDDEN;
//                $task->save();
//                Yii::$app->session->setFlash('taskMessage', "Задача просрочена");
//            }
//        }
//

$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 100,
    ],
    'sort' => [
        'defaultOrder' => [
            'dt_add' => SORT_DESC
        ]
    ],
]);

?>

<?= ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_item'
    ])
?>

