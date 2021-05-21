<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskComplete extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Выполнить';
        $this->codeName = 'Execute';
    }

    public function checkAccess(string $status, int $customerId,int $executorId, int $currentId): bool
    {
        if ($status === Task::STATUS_IN_WORK && $currentId === $executorId) {
            return true;
        }
        return false;
    }
}

