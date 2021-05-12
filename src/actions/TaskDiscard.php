<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskDiscard extends AbstractAction
{
    public function getName(): string
    {
        return 'Отказаться';
    }

    public function getCodeName(): string
    {
        return Task::ACTION_FAIL;
    }

    public function checkAccess(string $status, int $clientId,int $masterId, int $currentId): bool
    {
        if ($status === Task::STATUS_IN_WORK && $currentId === $masterId) {
            return true;
        }
        return false;
    }
}

