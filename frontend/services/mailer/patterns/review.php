<?php

/**
 * @var $task Tasks
 * @var $result array
 */

use frontend\models\Tasks;

return '<h3>У вас новый отзыв по заданию - "' . $task->name . '"</h3>
        <a href="http://taskforce/user/'. $task->executor_id .'"><button>Посмотреть отзыв</button></a>
' . require 'layouts/footer.php';