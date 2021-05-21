<?php


namespace taskforce\actions;

abstract class AbstractAction
{
    protected string $name;
    protected string $codeName;

    public function getName(): string
    {
        return $this->name;

    }
    public function getCodeName(): string
    {
        return $this->codeName;
    }

    abstract protected function checkAccess(string $status, int $customerId, int $executorId, int $currentId): bool;
}
