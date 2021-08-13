<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskAccept extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Принять';
        $this->codeName = 'Accept';
    }

    public function checkAccess(string $status, int $customerId,int $executorId, int $currentId): bool
    {
        if ($status === Task::STATUS_NEW && $currentId === $customerId) {
            return true;
        }
        return false;
    }
}
