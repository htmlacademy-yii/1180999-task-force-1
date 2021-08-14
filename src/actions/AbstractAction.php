<?php


namespace taskforce\actions;


abstract class AbstractAction
{
    protected string $name;
    protected string $codeName;

    /**
     * @return string возвращает русскоязычное название действия
     */
    public function getName(): string
    {
        return $this->name;

    }

    /**
     * @return string возвращает кодовое название действия
     */
    public function getCodeName(): string
    {
        return $this->codeName;
    }

    /**
     * Функция проверки доступа для действия над заданием
     * @param string $status текущий статус
     * @param int $customerId id автора
     * @param int $executorId id исполнителя
     * @param int $currentId id текущего пользователя
     * @return bool возвращает true если доступ разрешен, либо false в противном случае
     */
    abstract protected function checkAccess(string $status, int $customerId, int $executorId, int $currentId): bool;
}
