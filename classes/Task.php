<?php

class Task
{
    //Статусы
    const STATUS_NEW = 'Новое';
    const STATUS_CANCEL = 'Отменено';
    const STATUS_IN_WORK = 'Выполняется';
    const STATUS_SUCCESS = 'Завершено';
    const STATUS_FAIL = 'Провалено';

    //Действия
    const ACTION_CANCEL = 'отменить';
    const ACTION_RESPONSE = 'откликнуться';
    const ACTION_FAIL = 'отказаться';
    const ACTION_SUCCESS = 'выполнить';

    protected string $name = '';
    protected string $status = '';
    protected int $clientId = 0;
    protected int $masterId = 0;

    public function __construct($name, $clientId)
    {
        $this->name = $name;
        $this->status = self::STATUS_NEW;
        $this->clientId = $clientId;
    }

    public function getActions($status): ?array
    {
        if ($status === self::STATUS_NEW)
        {
            return [self::ACTION_CANCEL, self::ACTION_RESPONSE];
        }

        if ($status === self::STATUS_IN_WORK)
        {
            return [self::ACTION_SUCCESS, self::ACTION_FAIL];
        }

        return null;
    }

    public function getNextStatus($action): ?string
    {
        switch ($action) {
            case self::ACTION_CANCEL:
                return self::STATUS_CANCEL;
                break;
            case self::ACTION_RESPONSE:
                return self::STATUS_IN_WORK;
                break;
            case self::ACTION_FAIL:
                return self::STATUS_FAIL;
                break;
            case self::ACTION_SUCCESS:
                return self::STATUS_SUCCESS;
        }
        return null;
    }
}
