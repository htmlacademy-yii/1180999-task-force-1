<?php

require 'classes/Task.php';

describe("Проверяем доступные действия на статус", function() {

    context("Когда задача создана", function () {
        it("Доступные действия: отменить, откликнуться", function () {
            $task = new Task('test', 1);
            $res = $task->getActions(Task::STATUS_NEW);
            expect($res)->toBe([Task::ACTION_CANCEL, Task::ACTION_RESPONSE]);
        });
    });

    context("Когда задача в работе", function () {
        it("Доступные действия: отказаться, выполнить", function () {
            $task = new Task('test', 1);
            $res = $task->getActions(Task::STATUS_IN_WORK);
            expect($res)->toBe([Task::ACTION_SUCCESS, Task::ACTION_FAIL]);
        });
    });

    context("Если задача отменена", function () {
        it("Доступных действий нет", function () {
            $task = new Task('test', 1);
            $res = $task->getActions(Task::STATUS_CANCEL);
            expect($res)->toBe(null);
        });
    });

    context("Если задача завершена", function () {
        it("Доступных действий нет", function () {
            $task = new Task('test', 1);
            $res = $task->getActions(Task::STATUS_SUCCESS);
            expect($res)->toBe(null);
        });
    });

    context("Если задача провалена", function () {
        it("Доступных действий нет", function () {
            $task = new Task('test', 1);
            $res = $task->getActions(Task::STATUS_FAIL);
            expect($res)->toBe(null);
        });
    });
});

describe("Проверяем текущий статус задачи", function() {

    context("Когда задачу отменили", function () {
        it('Ожидаем статус: отменено', function() {
            $task = new Task('test', 1);
            $res = $task->getNextStatus(Task::ACTION_CANCEL);
            expect($res)->toBe(Task::STATUS_CANCEL);
        });
    });

    context("Когда задачу вязли в работу", function () {
        it('Ожидаем статус: выполняется', function() {
            $task = new Task('test', 1);
            $res = $task->getNextStatus(Task::ACTION_RESPONSE);
            expect($res)->toBe(Task::STATUS_IN_WORK);
        });
    });

    context("Когда отказались от задачи", function () {
        it('Ожидаем статус: провалено', function() {
            $task = new Task('test', 1);
            $res = $task->getNextStatus(Task::ACTION_FAIL);
            expect($res)->toBe(Task::STATUS_FAIL);
        });
    });

    context("Когда задачу выполнили", function () {
        it('Ожидаем статус: завершено', function() {
            $task = new Task('test', 1);
            $res = $task->getNextStatus(Task::ACTION_SUCCESS);
            expect($res)->toBe(Task::STATUS_SUCCESS);
        });
    });
});
