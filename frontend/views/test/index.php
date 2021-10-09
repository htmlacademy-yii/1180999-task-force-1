<?php

$model = new \frontend\services\TaskGetService();
$task = $model->getTask(176);

foreach ($task->reviews as $review) {
    print "Задача: " . $review->task->name . "<br>";
    print "Отзыв: " . $review->text . "<br>";
    print "Оценка (1-5): " . $review->score . "<br>";
    print "Отправлено: " . Yii::$app->formatter->format($review->dt_add, 'relativeTime') . "<br>";
}

foreach ($task->tasksFiles as $files) {
    var_dump($files);
}
