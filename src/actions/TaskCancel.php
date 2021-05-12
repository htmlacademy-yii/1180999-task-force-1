<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskCancel extends AbstractAction
{
    public function getName(): string
    {
        return 'Отменить';
    }

    public function getCodeName(): string
    {
        return Task::ACTION_CANCEL;
    }

    public function checkAccess(string $status, int $clientId, int $masterId, int $currentId): bool
    {
        if ($status === Task::STATUS_NEW && $clientId === $masterId && $currentId === $clientId) {
            return true;
        }
        return false;
    }
}

