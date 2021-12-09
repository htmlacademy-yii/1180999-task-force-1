<?php

/**
 * @var $value UsersMessages;
 */

namespace frontend\controllers;

use frontend\models\Tasks;
use taskforce\Task;
use Yii;
use yii\web\Controller;


class TestController extends Controller
{
    public function actionRun()
    {
        $task = Tasks::findOne(\Yii::$app->request->get('id'));

        return $this->render('index', compact('task'));
    }
}
