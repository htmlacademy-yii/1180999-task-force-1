<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Files;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Responses;
use frontend\models\TasksFiles;
use frontend\models\TasksSearch;
use frontend\models\Users;
use yii\db\Exception;
use yii\web\Controller;
use Yii;
use frontend\models\Tasks;
use taskforce\Task;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $categories = Categories::find()->all();
        $modelForm = new TaskFilterForm();

        if ($modelForm->load(Yii::$app->request->get())) {

            $taskSearch = new TasksSearch();
            $dataProvider = $taskSearch->search($modelForm);
            $tasks = $dataProvider->getModels();
        } else {
            $tasks = Tasks::find()->all();
        }

        return $this->render(
            'tasks', [
                'modelForm' => $modelForm,
                'tasks' => $tasks,
                'categories' => $categories
            ]
        );
    }

    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("Задачи с id = $id не существует");
        }
        return $this->render('view', [
            'task' => $task
        ]);
    }

}
