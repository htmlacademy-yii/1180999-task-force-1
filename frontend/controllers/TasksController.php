<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\TaskFilterForm;
use yii\web\Controller;
use Yii;
use frontend\models\Tasks;
use taskforce\Task;

class TasksController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {

        // подгружаю категории
        $categories = Categories::find()->all();;

        // создаю объект формы
        $model_form = new TaskFilterForm();

        // запрос на получение задач со статусом "новое" и сортировка по дате
        $query = Tasks::find()->where(['status' => Task::STATUS_NEW]);
        $query->orderBy('dt_add');
        $tasks = $query->all();

        // получаю данные из формы и отправляю в представление
        if ($model_form->load(Yii::$app->request->get())) {

            $query = Tasks::find()->where([
                'category_id' => Yii::$app->request->get('TaskFilterForm')['categories'],
                'executor_id' => Yii::$app->request->get('TaskFilterForm')['noExecutor'],
                'status' => Task::STATUS_NEW
            ]);
            $query->orderBy('dt_add');
            $tasks = $query->all();

            return $this->render(
                'tasks', [
                    'model' => $model_form,
                    'tasks' => $tasks,
                    'categories' => $categories
                ]
            );
        }

        return $this->render(
            'tasks', [
                'model' => $model_form,
                'tasks' => $tasks,
                'categories' => $categories
            ]
        );
    }

}
