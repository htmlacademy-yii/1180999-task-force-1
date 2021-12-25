<?php

namespace frontend\controllers;

use app\models\Notifications;
use frontend\models\Categories;
use frontend\models\Cities;
use frontend\models\forms\TaskFilterForm;
use frontend\models\Responses;
use frontend\models\TasksSearch;
use frontend\models\Users;
use frontend\services\mailer\MailerService;
use frontend\services\NoticeService;
use frontend\services\TaskGetService;
use frontend\services\TaskCompletionService;
use frontend\services\TaskResponseService;
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

        if ($modelForm->load(Yii::$app->request->get())) {
            $taskSearch = new TasksSearch();
            $provider = $taskSearch->search($modelForm);
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
        $respondID = $respondService->execute(Yii::$app->request->post(), $task);
        if ($respondID) {
            return $this->redirect(Url::to(['tasks/view', 'id' => $task->id]));
        }

        $TaskCompletionService = new TaskCompletionService;
        $taskClose = $TaskCompletionService->execute($task);

        if ($taskClose === 1) {
            if ($task->executor->notification_task_action === 1) {
                $service = new NoticeService();
                $service->run($service::ACTION_CLOSE_TASK, $task->executor_id, $task->id);
            }
            return $this->redirect(Url::to(['tasks/index']));
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
            $service = new NoticeService();
            $service->run($service::ACTION_REFUSE_RESPONSE, $response->executor_id, $response->task_id);
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
            $service = new NoticeService();
            $service->run($service::ACTION_ACCEPT_RESPONSE, $executor->id, $task->id);

            $mailer = new MailerService();
            $mailer->send($mailer::START_MESSAGE, $task, $task->executor->email);
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
            $service = new NoticeService();
            $service->run($service::ACTION_REFUSAL_OF_TASK, $task->user_id, $task->id);

            $mailer = new MailerService();
            $mailer->send($mailer::REFUSAL_MESSAGE, $task, $task->user->email);
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