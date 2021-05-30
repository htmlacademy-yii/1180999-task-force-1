<?php

/**
 * Это тестовый скрипт
 */

use taskforce\Task;
use taskforce\actions\TaskAccept;

require_once __DIR__ . '/vendor/autoload.php';


try {
    $task = new Task('Test', 1);
    var_dump($task);
    $task->getNextStatus(new TaskAccept());
    $action = new TaskAccept();
    print $action->checkAccess('Новое',1,2,1);
} catch (Exception $e) {
    print $e->getMessage();
}

finally {
    die();
}


