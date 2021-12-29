<?php

/**
 * @var $time
 */
?>

<span class="new-task__time">
    <?= Yii::$app->formatter->format($time, 'relativeTime') ?>
</span>

