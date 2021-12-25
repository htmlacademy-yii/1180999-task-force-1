<?php

/**
 * @var $task Tasks
 */

use frontend\models\Tasks;

return'<h3>Задание завершено - "' . $task->name . '"</h3>
        <a href="http://taskforce/task/'. $task->id .'"><button>Открыть задание</button></a>
' . require_once 'layouts/footer.php';

