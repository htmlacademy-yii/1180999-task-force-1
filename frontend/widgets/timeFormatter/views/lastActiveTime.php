<?php

/**
 * @var string $time
 */

if (!$time) {
    $text = '<span style="color:red">Нет посещений</span>';
} else {
    $text = 'Был на сайте: <span style="color: forestgreen">' . Yii::$app->formatter->format($time, 'relativeTime') . '</span>';
}
?>

<span class="new-task__time"><?= $text ?></span>
