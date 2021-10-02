<?php

namespace frontend\services;

use frontend\models\Tasks;

class TaskGetService
{
    private Tasks $task;
    private array $executors;

    /**
     * Поиск задачи в БД
     * @param int $id
     * @return Tasks|null Данные найденной задачи
     */
    public function getTask(int $id): ?Tasks
    {
        $this->task = Tasks::findOne($id);
        return $this->task;
    }

    /**
     * Возвращает массив с id исполнителей, которые откликнулись на задачу
     * @return array Если откликов нет, возвращает пустой массив
     */
    public function getExecutors(): array
    {
        $responses = $this->task->responses;

        if (!$responses) {
            return [];
        }

        foreach ($responses as $respond) {
            $this->executors[] = $respond->executor_id;
        }
        return $this->executors;
    }
}