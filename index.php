<?php

require_once __DIR__ . '/vendor/autoload.php';

$task = new \taskforce\Task('name', 1);

$action = new \taskforce\actions\TaskCancel();
print $action->getCodeName();

print $task->getNextStatus(new \taskforce\actions\TaskAccept());
print_r($task->getActions(\taskforce\Task::STATUS_IN_WORK));

