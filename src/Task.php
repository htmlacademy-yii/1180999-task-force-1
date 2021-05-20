<?php
namespace taskforce;

use taskforce\actions\AbstractAction;
use taskforce\actions\TaskAccept;
use taskforce\actions\TaskCancel;
use taskforce\actions\TaskComplete;
use taskforce\actions\TaskDiscard;
use taskforce\actions\TaskResponse;

class Task
{
    const STATUS_NEW = 'Новое';
    const STATUS_CANCEL = 'Отменено';
    const STATUS_IN_WORK = 'В работе';
    const STATUS_SUCCESS = 'Выполнено';
    const STATUS_FAIL = 'Провалено';

    const ACTION_STATUS_MAP = [
        'Cancel' => self::STATUS_CANCEL,
        'Respond' => self::STATUS_IN_WORK,
        'Refuse' => self::STATUS_FAIL,
        'Execute' => self::STATUS_SUCCESS,
        'Accept' => self::STATUS_IN_WORK
    ];

    protected string $name;
    protected string $status;
    protected int $customerId;
    protected int $executorId;

    /**
     * Task constructor.
     * Конструктор создает экземпляр класса, в который обязательно нужно передать имя и id-заказчика
     * Статус задания при это автоматически переходит в "новое"
     * @param string $name наименование задания
     * @param int $customerId идентификатор заказчика
     */
    public function __construct(string $name, int $customerId)
    {
        $this->name = $name;
        $this->status = self::STATUS_NEW;
        $this->customerId = $customerId;
        $this->executorId = $customerId;
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
            return [new TaskCancel(), new TaskResponse(), new TaskAccept()];
        }

        if ($status === self::STATUS_IN_WORK)
        {
            return [new TaskComplete(), new TaskDiscard()];
        }

        return null;
    }

    /**
     * Функция возвращает имя статуса, в который перейдёт задание после выполнения конкретного действия.
     * @param AbstractAction $action передаваемое действие
     * @return string|null возвращает имя статуса
     */
    public function getNextStatus(AbstractAction $action): ?string
    {
        return self::ACTION_STATUS_MAP[$action->getCodeName()] ?? null;
    }
}
