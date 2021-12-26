<?php

/**
 * @var $task Tasks
 */

use frontend\models\Tasks;

return'<h3>К сожалению, исполнитель отказался от выполнения задания - "' . $task->name . '"</h3>
        <a href="http://taskforce/task/'. $task->id .'"><button>Открыть задание</button></a><br><br>
        <a href="http://taskforce/user/'. $task->executor_id .'"><button>Открыть профиль исполнителя</button></a>
' . require_once 'layouts/footer.php';
