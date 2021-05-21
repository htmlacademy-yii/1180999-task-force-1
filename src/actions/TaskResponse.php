<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskResponse extends AbstractAction
{
    public function __construct()
    {
        $this->name = 'Откликнуться';
        $this->codeName = 'Respond';
    }

    public function checkAccess(string $status, int $customerId,int $executorId, int $currentId): bool
    {
        if ($status === Task::STATUS_NEW && $currentId != $customerId) {
            return true;
        }
        return false;
    }
}
