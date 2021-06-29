<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Tasks;

class TasksController extends Controller
{
    /**
     * Функция формирует объект с данными задач
     * @return string
     */
    public function actionIndex(): string
    {
        $tasks = Tasks::find()->all();

        return $this->render(
            'tasks',
            ['tasks' => $tasks]
        );
    }

}
