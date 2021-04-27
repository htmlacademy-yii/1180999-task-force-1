<?php

require_once 'vendor/autoload.php';

describe("Проверяем доступные действия на статус", function() {

    context("Когда задача создана", function () {
        it("Доступные действия: отменить, откликнуться", function () {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getActions(\taskforce\Task::STATUS_NEW);
            expect($res)->toBe([\taskforce\Task::ACTION_CANCEL, \taskforce\Task::ACTION_START]);
        });
    });

    context("Когда задача в работе", function () {
        it("Доступные действия: отказаться, выполнить", function () {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getActions(\taskforce\Task::STATUS_IN_WORK);
            expect($res)->toBe([\taskforce\Task::ACTION_SUCCESS, \taskforce\Task::ACTION_FAIL]);
        });
    });

    context("Если задача отменена", function () {
        it("Доступных действий нет", function () {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getActions(\taskforce\Task::STATUS_CANCEL);
            expect($res)->toBe(null);
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
            $res = $task->getNextStatus(\taskforce\Task::ACTION_CANCEL);
            expect($res)->toBe(\taskforce\Task::STATUS_CANCEL);
        });
    });

    context("Когда задачу вязли в работу", function () {
        it('Ожидаем статус: выполняется', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(\taskforce\Task::ACTION_START);
            expect($res)->toBe(\taskforce\Task::STATUS_IN_WORK);
        });
    });

    context("Когда отказались от задачи", function () {
        it('Ожидаем статус: провалено', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(\taskforce\Task::ACTION_FAIL);
            expect($res)->toBe(\taskforce\Task::STATUS_FAIL);
        });
    });

    context("Когда задачу выполнили", function () {
        it('Ожидаем статус: завершено', function() {
            $task = new \taskforce\Task('test', 1);
            $res = $task->getNextStatus(\taskforce\Task::ACTION_SUCCESS);
            expect($res)->toBe(\taskforce\Task::STATUS_SUCCESS);
        });
    });
});
