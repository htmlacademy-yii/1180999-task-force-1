<?php

/**
 * @var $value UsersMessages;
 */

namespace frontend\controllers;

use frontend\models\Tasks;
use Yii;
use yii\web\Controller;


class TestController extends Controller
{
    public function actionIndex()
    {
//        Данные
        $task_id = Yii::$app->request->get('task_id');
        $task = Tasks::findOne($task_id);

        return $this->render('index', [
            'task' => $task
        ]);
    }
}
