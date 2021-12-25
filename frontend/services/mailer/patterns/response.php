<?php

/**
 * @var $task Tasks
 */

use frontend\models\Tasks;

return'<h3>Новый отклик по заданию - "' . $task->name . '"</h3>
        <a href="http://taskforce/task/'. $task->id .'"><button>Посмотерть отклик</button></a>
' . require_once 'layouts/footer.php';

