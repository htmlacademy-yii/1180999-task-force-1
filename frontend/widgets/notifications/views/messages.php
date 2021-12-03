<?php

/**
 * @var $notifications
 * @var Tasks $task
 */

use frontend\models\Tasks;
use taskforce\Task;

?>

<?php if ($notifications): ?>
    <a href="/task/<?= $task->id ?>" class="my-list__bottom-chat  my-list__bottom-chat--new">
        <b><?= count($notifications) ?></b>
    </a>
<?php elseif ($task->status != Task::STATUS_IN_WORK): ?>
    <a href="#" class="my-list__bottom-chat" style="opacity: 0"></a>
<?php else: ?>
    <a href="/task/<?= $task->id ?>" class="my-list__bottom-chat"></a>
<?php endif; ?>

