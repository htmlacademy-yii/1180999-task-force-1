<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskResponse extends AbstractAction
{
    public function getName(): string
    {
        return 'Откликнуться';
    }

    public function getCodeName(): string
    {
        return Task::ACTION_START;
    }

    public function checkAccess(string $status, int $clientId,int $masterId, int $currentId): bool
    {
        if ($status === Task::STATUS_NEW && $currentId != $clientId) {
            return true;
        }
        return false;
    }
}
