<?php

/**
 * @var $notifications
 * @var Tasks $task
 */

use frontend\models\Tasks;
use taskforce\Task;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if ($notifications): ?>
    <?= Html::a("<b>" . count($notifications) . "</b>",
        Url::to(['tasks/view', 'id' => $task->id]),
        ['class' => 'my-list__bottom-chat  my-list__bottom-chat--new']
    ) ?>
<?php elseif ($task->status != Task::STATUS_IN_WORK): ?>
    <a href="#" class="my-list__bottom-chat" style="opacity: 0"></a>
<?php else: ?>
    <?= Html::a('',
        Url::to(['tasks/view', 'id' => $task->id]),
        ['class' => 'my-list__bottom-chat']
    ) ?>
<?php endif; ?>

