<?php

namespace taskforce;

use taskforce\actions\AbstractAction;
use taskforce\actions\TaskAccept;
use taskforce\actions\TaskCancel;
use taskforce\actions\TaskComplete;
use taskforce\actions\TaskDiscard;
use taskforce\actions\TaskResponse;
use taskforce\exceptions\TaskActionException;
use taskforce\exceptions\TaskCreateException;
use taskforce\exceptions\TaskStatusException;

class Task
{
    const STATUS_NEW = 'Новое';
    const STATUS_CANCEL = 'Отменено';
    const STATUS_IN_WORK = 'В работе';
    const STATUS_SUCCESS = 'Выполнено';
    const STATUS_FAIL = 'Провалено';
    const STATUS_COMPLETE = 'Завершено';

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
    protected ?int $executorId;

    /**
     * Task constructor.
     * Конструктор создает экземпляр класса, в который обязательно нужно передать имя и идентификатор заказчика
     * Статус задания при это автоматически переходит в "Новое"
     * @param string $name наименование задания
     * @param int $customerId идентификатор заказчика
     * @param ?int $executorId идентификатор исполнителя
     * @throws TaskCreateException исключение, если не введено название или неверный идентификатор заказчика
     */
    public function __construct(string $name, int $customerId, ?int $executorId = null)
    {
        if (!$name) {
            throw new TaskCreateException('Ошибка создания задания: не указано наименование');
        }
        $this->name = $name;
        $this->status = self::STATUS_NEW;
        $this->customerId = $customerId;
        $this->executorId = $executorId;
    }


    /**
     * @param string $status статус задания
     * @return array|null список доступных действий
     * @throws TaskStatusException исключение, если статус будет не найден или пустой
     */
    public function getActions(string $status): ?array
    {
        if (!in_array($status, $this->getStatuses())) {
            throw new TaskStatusException('Статус не найден');
        }

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
     * @throws TaskActionException исключение, если передано неверное действие
     */
    public function getNextStatus(AbstractAction $action): ?string
    {
        if (!array_key_exists($action->getCodeName(), self::ACTION_STATUS_MAP)) {
            throw new TaskActionException('Неверное действие');
        }
        return self::ACTION_STATUS_MAP[$action->getCodeName()] ?? null;
    }

    /**
     * Функция возвращает массив со статусами
     * @return string[] список статусов
     */
    private function getStatuses(): array
    {
        return [self::STATUS_NEW, self::STATUS_CANCEL, self::STATUS_IN_WORK, self::STATUS_SUCCESS, self::STATUS_FAIL];
    }

}
