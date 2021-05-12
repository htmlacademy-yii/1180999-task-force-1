<?php


namespace taskforce\actions;

abstract class AbstractAction
{
    abstract protected function getName(): string;
    abstract protected function getCodeName(): string;
    abstract protected function checkAccess(string $status, int $clientId, int $masterId, int $currentId): bool;
}
