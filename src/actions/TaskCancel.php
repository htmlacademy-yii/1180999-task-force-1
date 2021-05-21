<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskCancel extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Отменить';
        $this->codeName = 'Cancel';
    }

    public function checkAccess(string $status, int $customerId,int $executorId, int $currentId): bool
    {
        if ($status === Task::STATUS_NEW && $customerId === $executorId && $currentId === $customerId) {
            return true;
        }
        return false;
    }
}

