<?php

require_once __DIR__ . '/classes/Task.php';

$task = new Task('test', 1);
print_r($task->getActions(task::STATUS_CANCEL));
