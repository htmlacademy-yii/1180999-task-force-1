<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskAccept extends AbstractAction
{
    public function getName(): string
    {
        return 'Принять';
    }

    public function getCodeName(): string
    {
        return Task::ACTION_ACCEPT;
    }

    public function checkAccess(string $status, int $clientId,int $masterId, int $currentId): bool
    {
        if ($status === Task::STATUS_NEW && $currentId === $clientId) {
            return true;
        }
        return false;
    }
}
