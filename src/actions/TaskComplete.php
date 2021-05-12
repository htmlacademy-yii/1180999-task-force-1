<?php


namespace taskforce\actions;
use taskforce\Task;

class TaskComplete extends AbstractAction
{
    public function getName(): string
    {
        return 'Выполнить';
    }

    public function getCodeName(): string
    {
        return Task::ACTION_SUCCESS;
    }

    public function checkAccess(string $status, int $clientId, int $masterId, int $currentId): bool
    {
        if ($status === Task::STATUS_IN_WORK && $currentId === $masterId) {
            return true;
        }
        return false;
    }
}

