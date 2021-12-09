<?php

/**
 * @var \frontend\models\Tasks $model
 */

use frontend\models\Tasks;
use frontend\services\TaskTimeService;


?>
id: <?= $model->id ?> /  <?= $model->name ?> /  <?= $model->status ?> /
<?= $model->deadline?? '' ?> <br>