<?php

/**
 * @var $task Tasks
 */

use frontend\models\Tasks;

return'<h3>Новое сообщение по заданию - "' . $task->name . '"</h3>
        <a href="http://taskforce/task/'. $task->id .'"><button>Открыть сообщение</button></a>
' . require_once 'layouts/footer.php';

