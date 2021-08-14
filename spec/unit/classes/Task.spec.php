<?php

require_once 'vendor/autoload.php';

describe("Проверка прав на действия пользователя", function() {

    context("Статус Новая задача", function () {
        it("Отменить задание можно если id пользователя = id автора = id мастера", function () {
            $actionCancel = new \taskforce\actions\TaskCancel();
            $res = $actionCancel->checkAccess(\taskforce\Task::STATUS_NEW, 1, 1, 1);
            expect($res)->toBe(true);
        });
    });

    context("Статус Новая задача", function () {
        it("Откликнуться на задание может пользователь у которого id не равен id автора", function () {
            $actionCancel = new \taskforce\actions\TaskResponse();
            $res = $actionCancel->checkAccess(\taskforce\Task::STATUS_NEW, 1, 1, 2);
            expect($res)->toBe(true);
        });
    });

    context("Статус Новая задача", function () {
        it("Принять отклик может пользователь, у которого id = id автора", function () {
            $actionCancel = new \taskforce\actions\TaskAccept();
            $res = $actionCancel->checkAccess(\taskforce\Task::STATUS_NEW, 1, 1, 1);
            expect($res)->toBe(true);
        });
    });

    context("Статус в работе", function () {
        it("Отказаться от задания может пользователь, у которого id = id мастера", function () {
            $actionCancel = new \taskforce\actions\TaskDiscard();
            $res = $actionCancel->checkAccess(\taskforce\Task::STATUS_IN_WORK, 1, 3, 3);
            expect($res)->toBe(true);
        });
    });

    context("Статус в работе", function () {
        it("Завершить задание может пользователь, у которого id = id мастера", function () {
            $actionCancel = new \taskforce\actions\TaskComplete();
            $res = $actionCancel->checkAccess(\taskforce\Task::STATUS_IN_WORK, 1, 3, 3);
            expect($res)->toBe(true);
        });
    });

});

//
describe("Проверяем доступные действия на статус", function() {

    context("Когда задача создана", function () {
        it("Доступные действия: отменить, откликнуться", function () {
            $task = new \taskforce\Task('test', 1);
            $getActions = $task->getActions(\taskforce\Task::STATUS_NEW);
            $res = [];
            foreach ($getActions as $v) {
                $res[] = $v->getName();
            }
             expect($res)->toBe(['Отменить', 'Откликнуться', 'Принять']);
        });
    });

    context("Когда задача в работе", function () {
        it("Доступные действия: отказаться, выполнить", function () {
            $task = new \taskforce\Task('test', 1);
            $getActions = $task->getActions(\taskforce\Task::STATUS_IN_WORK);
            $res = [];
            foreach ($getActions as $v) {
                $res[] = $v->getName();
            }
            expect($res)->toBe(['Выполнить', 'Отказаться']);
        });
    });

    context("Если задача отменена", function () {
        it("Доступных действий нет", function () {
            try {
                $task = new \taskforce\Task('test', 1);
                $res = $task->getActions('Cancel');
            } catch (Exception $e) {
                $res = $e->getMessage();
            }
            expect($res)->toBe('Статус не найден');
        });
    });

    context("Если задача завершена", function () {
        it("Доступных действий нет", function () {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getActions(\taskforce\Task::STATUS_SUCCESS);
            expect($res)->toBe(null);
        });
    });

    context("Если задача провалена", function () {
        it("Доступных действий нет", function () {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getActions(\taskforce\Task::STATUS_FAIL);
            expect($res)->toBe(null);
        });
    });
});

describe("Проверяем текущий статус задачи", function() {

    context("Когда задачу отменили", function () {
        it('Ожидаем статус: отменено', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(new \taskforce\actions\TaskCancel());
            expect($res)->toBe(\taskforce\Task::STATUS_CANCEL);
        });
    });

    context("Когда задачу вязли в работу", function () {
        it('Ожидаем статус: выполняется', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(new \taskforce\actions\TaskResponse());
            expect($res)->toBe(\taskforce\Task::STATUS_IN_WORK);
        });
    });

    context("Когда отказались от задачи", function () {
        it('Ожидаем статус: провалено', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(new \taskforce\actions\TaskDiscard());
            expect($res)->toBe(\taskforce\Task::STATUS_FAIL);
        });
    });

    context("Когда задачу приняли в работу", function () {
        it('Ожидаем статус: новая задача', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(new \taskforce\actions\TaskAccept());
            expect($res)->toBe(\taskforce\Task::STATUS_IN_WORK);
        });
    });

    context("Когда задачу выполнили", function () {
        it('Ожидаем статус: завершено', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(new \taskforce\actions\TaskComplete());
            expect($res)->toBe(\taskforce\Task::STATUS_SUCCESS);
        });
    });
});
