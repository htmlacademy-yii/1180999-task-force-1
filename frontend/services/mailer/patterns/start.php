<?php

/**
 * @var $task Tasks
 */

use frontend\models\Tasks;

return'<h3>Поздравляем, ваш отклик принят. Вы можете приступать к выполнению задания - "' . $task->name . '"</h3>
        <a href="http://taskforce/task/'. $task->id .'"><button>Открыть задание</button></a><br><br>
' . require_once 'layouts/footer.php';
