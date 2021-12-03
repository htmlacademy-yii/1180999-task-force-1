<?php

/**
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 * @var Notifications $notification
 */

use app\models\Notifications;
use yii\helpers\Url;
use yii\web\Controller;

print Yii::$app->security->generatePasswordHash('123');
print '<hr>';

$notifications = \app\models\Notifications::find()
    ->where(['user_id' => 1])
    ->andWhere(['and', ['is_read' => 0]])
    ->all();

$user = \frontend\models\Users::findOne(4);
//
//class EventsController extends Controller
//{
//    public function actionIndex()
//    {
//        $notifications = \app\models\Notifications::find()
//            ->where(['user_id' => Yii::$app->user->identity->getId()])
//            ->andWhere(['and', ['is_read' => 0]])
//            ->all();
//
//        foreach ($notifications as $notification) {
//            $notification->is_view = 1;
//            $notification->save();
//        }
//    }
//}
?>


<?= NotificationsWidget::widget(['user' => $user]) ?>