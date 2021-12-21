<?php

namespace frontend\controllers;

use app\models\Notifications;
use frontend\models\Categories;
use frontend\models\Cities;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Responses;
use frontend\models\TasksSearch;
use frontend\models\Users;
use frontend\services\api\GeoCoderApi;
use frontend\services\TaskGetService;
use frontend\services\TaskCompletionService;
use frontend\services\TaskResponseService;
use frontend\services\TaskTimeService;
use GuzzleHttp\Exception\GuzzleException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\filters\AccessControl;
use Yii;
use frontend\models\Tasks;
use taskforce\Task;
use frontend\services\TaskCreateService;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
                            'accept',
                            'refusal'
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
        $lostTasks = new TaskTimeService();
        $lostTasks->tasks = Tasks::find()->where(['not', ['deadline' => null]])
            ->andWhere(['not', ['status' => Task::STATUS_HIDDEN]]);
        $lostTasks->execute();

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
        ]);
    }

    /**
     * Показ страницы задачи
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $getTaskService = new TaskGetService();
        $task = $getTaskService->getTask($id);
        $user = Users::findOne($task->user_id);

        if (!$task) {
            throw new NotFoundHttpException("Задача с id $id не найдена");
        }

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
                'user' => $user,
                'executors' => $getTaskService->getExecutors(),
                'responseForm' => $respondService->getForm(),
                'completionForm' => $TaskCompletionService->getForm(),
                ]
        );
    }

    /**
     * Действие создания новой задачи
     * @return string
     */
    public
    function actionCreate(): string
    {
        $categories = Categories::find()->select(['name', 'id'])->indexBy('id')->column();
        $cities = ArrayHelper::getColumn(Cities::find()->all(), 'name');
        $service = new TaskCreateService();
        $taskId = $service->execute(Yii::$app->request->post());
        if ($taskId) {
            $this->redirect("task/$taskId");
        }

        return $this->render('create', [
            'model' => $service->getForm(),
            'cities' => $cities,
            'categories' => $categories
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

        if ($response->executor->notification_task_action === 1) {
            $notice = new Notifications();
            $notice->title = Notifications::TITLE_REFUSE_RESPONSE;
            $notice->icon = Notifications::ICONS_REFUSE_RESPONSE;
            $notice->description = Tasks::findOne($response->task_id)->name;
            $notice->task_id = $response->task_id;
            $notice->user_id = $response->executor_id;
            $notice->save();
        }

        $this->redirect("/task/$response->task_id");
    }

    /**
     * Действие запуска задачи
     * @param int $id
     */
    public
    function actionAccept(int $id)
    {
        $response = Responses::findOne($id);
        $executor = Users::findOne($response->executor_id);
        $task = Tasks::findOne($response->task_id);

        $task->executor_id = $response->executor_id;
        $task->status = Task::STATUS_IN_WORK;
        $task->cost = $response->price;
        $task->save();

        $executor->is_executor = 1;
        $executor->save();

        if ($executor->notification_task_action === 1) {
            $notice = new Notifications();
            $notice->title = Notifications::TITLE_SELECT_EXECUTOR;
            $notice->icon = Notifications::ICONS_SELECT_EXECUTOR;
            $notice->description = Tasks::findOne($task->id)->name;
            $notice->task_id = $task->id;
            $notice->user_id = $executor->id;
            $notice->save();
        }

        $this->redirect("/task/$task->id");
    }

    /**
     * Действие отказа от задачи
     * @param int $id
     */
    public function actionRefusal(int $id)
    {
        $task = Tasks::findOne($id);
        $task->status = Task::STATUS_FAIL;
        $task->save();

        $user = Users::findOne($task->executor_id);
        $user->failed_count++;
        $user->save();

        if ($task->user->notification_task_action === 1) {
            $notice = new Notifications();
            $notice->title = Notifications::TITLE_TASK_REFUSAL;
            $notice->icon = Notifications::ICONS_REFUSE_RESPONSE;
            $notice->description = Tasks::findOne($task->id)->name;
            $notice->task_id = $task->id;
            $notice->user_id = $task->user_id;
            $notice->save();
        }
        $this->redirect("/task/$task->id");
    }

    /**
     * Действие отмены задачи
     * @param int $id
     */
    public function actionCancel(int $id)
    {
        $task = Tasks::findOne($id);
        $task->status = Task::STATUS_CANCEL;
        $task->save();
        Yii::$app->session->setFlash('taskMessage', "Задача отменена");
        $this->redirect("/task/$task->id");
    }
}