<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Responses;
use frontend\models\TasksSearch;
use frontend\models\Users;
use frontend\services\TaskGetService;
use frontend\services\TaskCompletionService;
use frontend\services\TaskResponseService;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\filters\AccessControl;
use Yii;
use frontend\models\Tasks;
use taskforce\Task;
use frontend\services\TaskCreateService;

class TasksController extends SecuredController
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'view',
                            'create',
                            'cancel',
                            'response',
                            'refuse',
                            'accept'
                        ],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => [
                            'index',
                            'view'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'create'
                        ],
                        'allow' => false,
                        'roles' => ['?']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        $this->redirect(Url::to(['sign-up/index']));
                    }
                },
            ]
        ];
    }

    /**
     * Показ всех новых задач
     * @return string
     */
    public function actionIndex(): string
    {
        $categories = Categories::find()->all();
        $query = Tasks::find()->where(['status' => Task::STATUS_NEW]);
        $modelForm = new TaskFilterForm();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'dt_add' => SORT_DESC
                ]
            ],
        ]);

        $tasks = $provider->getModels();

        if ($modelForm->load(Yii::$app->request->get())) {
            $taskSearch = new TasksSearch();
            $provider = $taskSearch->search($modelForm);
            $tasks = $provider->getModels();
        }


        return $this->render('index', [
            'dataProvider' => $provider,
            'modelForm' => $modelForm,
            'categories' => $categories
        ]);
    }

    /**
     * Показ страницы задачи
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionView($id)
    {
        $getTaskService = new TaskGetService();
        $task = $getTaskService->getTask($id);

        $respondService = new TaskResponseService();
        $respondId = $respondService->execute(Yii::$app->request->post(), $task->id);

        $TaskCompletionService = new TaskCompletionService;
        $reviewId = $TaskCompletionService->execute(Yii::$app->request->post(), $task);


        if ($respondId) {
            return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        }

        if ($reviewId) {
            return $this->redirect(Url::to(['tasks']));
        }

        return $this->render('view', [
            'task' => $task,
            'executors' => $getTaskService->getExecutors(),
            'responseForm' => $respondService->getForm(),
            'completionForm' => $TaskCompletionService->getForm()
        ]);
    }

    /**
     * Действие создания новой задачи
     * @return string
     */
    public function actionCreate(): string
    {
        $service = new TaskCreateService();
        $taskId = $service->execute(Yii::$app->request->post());
        if ($taskId) {
            $this->redirect("task/$taskId");
        }

        return $this->render('create', [
            'model' => $service->getForm(),
        ]);
    }

    /**
     * Действие помечает отклик как отказанный
     * @param $id int Id отклика
     */
    public function actionRefuse(int $id)
    {
        $response = Responses::findOne($id);
        $response->refuse = Task::ACTION_STATUS_MAP['Refuse'];
        $response->save();

        $this->redirect("/task/$response->task_id");
    }

    /**
     * Действие запуска задачи
     * @param int $id
     */
    public function actionAccept(int $id)
    {
        $response = Responses::findOne($id);
        $executor = Users::findOne($response->executor_id);
        $task = Tasks::findOne($response->task_id);

        $task->executor_id = $response->executor_id;
        $task->status = Task::STATUS_IN_WORK;
        $task->save();

        $executor->is_executor = 1;
        $executor->save();

        $this->redirect("/task/$task->id");
    }

    /**
     * Действие отмены задачи
     * @param int $id
     */
    public function actionCancel(int $id)
    {
        $task = Tasks::findOne($id);
        $task->status = Task::STATUS_FAIL;
        $task->save();

        $user = Users::findOne($task->user_id);
        $user->failed_count++;
        $user->save();

        $this->redirect("/task/$task->id");
    }
}