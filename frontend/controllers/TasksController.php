<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\forms\TaskFilterForm;
use frontend\models\TasksSearch;
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
        $categories = Categories::find()->all();
        $modelForm = new TaskFilterForm();

        // получаю данные из формы и отправляю в представление
        if ($modelForm->load(Yii::$app->request->post())) {
            //modelform->attributes проверить данные после отправки

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

}
