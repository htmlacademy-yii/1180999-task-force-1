<?php
namespace taskforce;

class Task
{
    //Статусы
    const STATUS_NEW = 'Новое';
    const STATUS_CANCEL = 'Отменено';
    const STATUS_IN_WORK = 'В работе';
    const STATUS_SUCCESS = 'Выполнено';
    const STATUS_FAIL = 'Провалено';

    //Действия
    const ACTION_CANCEL = 'Отменить';
    const ACTION_START = 'Откликнуться';
    const ACTION_FAIL = 'Отказаться';
    const ACTION_SUCCESS = 'Выполнено';

    //Карта действий
    const ACTION_STATUS_MAP = [
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_START => self::STATUS_IN_WORK,
        self::ACTION_FAIL => self::STATUS_FAIL,
        self::ACTION_SUCCESS => self::STATUS_SUCCESS
    ];

    protected string $name;
    protected string $status;
    protected int $clientId;
    protected int $masterId;

    /**
     * Task constructor.
     * Конструктор создает экземпляр класса, в который обязательно нужно передать имя и id-заказчика
     * Статус задания при это автоматически переходит в "новое"
     * @param string $name наименование задания
     * @param int $clientId идентификатор заказчика
     */
    public function __construct(string $name, int $clientId)
    {
        $this->name = $name;
        $this->status = self::STATUS_NEW;
        $this->clientId = $clientId;
    }

    /**
     * Функция, возвращает список доступных действие на текущий статус задания
     * @param string $status статус задания
     * @return string[]|null возвращает массив из доступных действий
     */
    public function getActions(string $status): ?array
    {
        if ($status === self::STATUS_NEW)
        {
            return [self::ACTION_CANCEL, self::ACTION_START];
        }

        if ($status === self::STATUS_IN_WORK)
        {
            return [self::ACTION_SUCCESS, self::ACTION_FAIL];
        }

        return null;
    }

    /**
     * Функция возвращает имя статуса, в который перейдёт задание после выполнения конкретного действия.
     * @param string $action передаваемое действие
     * @return string|null возвращает имя статуса
     */
    public function getNextStatus(string $action): ?string
    {
        return self::ACTION_STATUS_MAP[$action] ?? null;
    }
}