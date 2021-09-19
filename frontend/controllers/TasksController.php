<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Files;
use frontend\models\forms\TaskCreate;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Responses;
use frontend\models\TasksFiles;
use frontend\models\TasksSearch;
use frontend\models\Users;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use frontend\models\Tasks;
use taskforce\Task;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->goBack();
                },
            ]
        ];
    }

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
            $tasks = Tasks::find()->orderBy('dt_add DESC')->all();
        }

        return $this->render(
            'tasks', [
                'modelForm' => $modelForm,
                'tasks' => $tasks,
                'categories' => $categories
            ]
        );
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("Задачи с id = $id не существует");
        }
        return $this->render('view', [
            'task' => $task
        ]);
    }

    /**
     * Действие создания новой задачи
     * @return int|string
     */
    public function actionCreate()
    {
        $model = new TaskCreate();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

            if ($model->upload()) {

                $newTask = new Tasks();

                $newTask->dt_add = date('Y-m-d');
                $newTask->deadline = $model->deadline;
                $newTask->user_id = Yii::$app->user->id;
                $newTask->category_id = 1;
                $newTask->name = $model->name;
                $newTask->description = $model->description;
                $newTask->cost = $model->cost;

                $newTask->city_id = 1;
                $newTask->status = 0;

                $newTask->save();

                $files = new TasksFiles();
                $files->task_id = $newTask->id;

                return $this->render('view', [
                    'task' => $newTask
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}