<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Files;
use frontend\models\forms\ResponseForm;
use frontend\models\forms\TaskCreateForm;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Responses;
use frontend\models\TasksFiles;
use frontend\models\TasksSearch;
use frontend\models\Users;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\Html;
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
                        'actions' => ['index', 'view', 'create', 'response'],
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
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $task = Tasks::findOne($id);
        $responseForm = new ResponseForm();

        if (!$task) {
            throw new NotFoundHttpException("Задачи с id = $id не существует");
        }

        if (Yii::$app->request->getIsPost()) {
            $responseForm->load(Yii::$app->request->post());
            if ($responseForm->load(Yii::$app->request->post())  && $responseForm->validate()) {
                $response = new Responses();
                $response->dt_add = date('Y-m-d H:i:s');
                $response->executor_id = Yii::$app->user->identity->getId();
                $response->task_id = $task->id;
                $response->price = $responseForm->price;
                $response->description = $responseForm->description;
                $response->save();

                return $this->redirect($task->id);
            }
        }

        return $this->render('view', [
            'task' => $task,
            'responseForm' => $responseForm
        ]);
    }

    /**
     * Действие создания новой задачи
     * @return int|string
     */
    public function actionCreate()
    {
        $model = new TaskCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $newTask = new Tasks();
            $newTask->dt_add = date('Y-m-d h:i:s');
            $newTask->user_id = Yii::$app->user->id;
            $newTask->category_id = $model->category;
            $newTask->name = $model->name;
            $newTask->description = $model->description;
            $newTask->cost = $model->cost;
            $newTask->deadline = $model->deadline;
            $newTask->location = 1;
            $newTask->status = Task::STATUS_NEW;
            $newTask->save();


            $model->files = UploadedFile::getInstances($model, 'files');

            if ($model->uploadFiles()) {

                $taskFiles = $model->uploadFiles();
                foreach ($taskFiles as $files) {
                    foreach ($files as $name => $path) {

                        $files = new Files();
                        $files->name = $name;
                        $files->path = $path;
                        $files->save();

                        $taskFiles = new TasksFiles();
                        $taskFiles->task_id = $newTask->id;
                        $taskFiles->file_id = $files->id;
                        $taskFiles->save();
                    }
                }
            }
            if ($newTask->id) {
                $this->redirect("task/$newTask->id");
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}