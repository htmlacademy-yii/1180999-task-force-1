<?php
/**
 * @var Tasks $task Данные задачи
 * @var Users $user Данные пользователя
 * @var array $address Данные пользователя
 * @var object $executors Данные задачи
 * @var object $responseForm Форма добавления отклика
 * @var object $completionForm Модель формы завершения задачи
 */


use frontend\models\Tasks;
use frontend\models\Users;
use frontend\widgets\customerInfo\CustomerInfo;
use taskforce\Task;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Files;

?>

<div class="main-container page-container">
    <section class="content-view">
        <?php if (Yii::$app->session->hasFlash('taskMessage')): ?>
            <?= Alert::widget([
                'body' => Yii::$app->session->getFlash('taskMessage'),
                'options' => [
                    'class' => 'alert alert-danger',
                    'style' => 'margin: 10px'
                ]
            ]);
            ?>
        <?php endif; ?>
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">

                        <h1><?= mb_strimwidth($task->name, 0, 30, "...") ?></h1>
                        <span>Размещено в категории
                            <a href="<?= Url::to(['tasks/index', 'TaskFilterForm' => ['category_ids' => $task->category_id]]) ?>"
                               class="link-regular">
                                <?= $task->category->name ?>
                            </a>
                            <?= date('Y-m-d', strtotime($task->dt_add)) ?>
                        </span>
                    </div>

                    <?php if ($task->cost): ?>
                        <b class="new-task__price new-task__price--<?= $task->category->code ?> content-view-price">
                            <?= $task->cost ?><b> ₽</b>
                        </b>
                    <?php endif; ?>


                    <div class="new-task__icon new-task__icon--<?= $task->category->code ?> content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p>
                        <?= $task->description ?>
                    </p>
                </div>

                <?php if ($task->tasksFiles): ?>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>
                    <?php foreach ($task->tasksFiles as $file): ?>
                        <?= Html::a(
                            Files::findOne(['id' => $file->file->id])->name,
                            Url::base() . '/' . Files::findOne(['id' => $file->file->id])->path,
                            ['target' => '_blank']
                        ); ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ($task->address): ?>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div class="content-view__map" id="map" style="width: 600px; height: 400px">
                            </div>
                            <div class="content-view__address">

                                <span class="address__town"><?= $address['city'] ?? ''?></span><br>
                                <span><?= $address['street'] ?? ''?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php if (!Yii::$app->user->isGuest): ?>

            <?php if ($task->status === Task::STATUS_IN_WORK
            || $task->status === Task::STATUS_NEW
            || $task->status === Task::STATUS_FAIL): ?>

            <div class="content-view__action-buttons">
                <?php if ($task->status === Task::STATUS_NEW && $task->user_id !== Yii::$app->user->getId()): ?>
                    <?php if (!in_array(Yii::$app->user->getId(), $executors)): ?>
                        <button class=" button button__big-color response-button open-modal"
                                type="button" data-for="response-form">Откликнуться
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($task->executor_id === Yii::$app->user->getId()
                    && $task->status != Task::STATUS_FAIL): ?>
                    <button class="button button__big-color refusal-button open-modal"
                            type="button" data-for="refuse-form">Отказаться
                    </button>
                <?php endif; ?>
                <?php if ($task->user_id === Yii::$app->user->getId() && !$task->executor_id): ?>
                    <?php if ($task->status != Task::STATUS_FAIL): ?>
                        <?= Html::a('<button class="button button__big-color refusal-button"
                                        type="button" data-for="refuse-form">Отменить
                                      </button>',
                            Url::to(['tasks/cancel', 'id' => $task->id])
                        ) ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($task->executor_id != Yii::$app->user->getId()): ?>
                    <?php if ($task->status === Task::STATUS_IN_WORK): ?>
                        <button class="button button__big-color request-button open-modal"
                                type="button" data-for="complete-form">Завершить
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="content-view__feedback">
            <?php if ($task->status === Task::STATUS_NEW) {
                if (count($task->responses) > 0 && $task->user_id === Yii::$app->user->identity->getId()) {
                    print $this->render('_responses', [
                        'task' => $task
                    ]);
                }
            }
            ?>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <div class="profile-mini__top">
                    <?= Html::img($user->avatarFile->path ?? '/img/no-photos.png', [
                        'width' => 62,
                        'height' => 62,
                        'alt' => 'Аватар заказчика',
                    ])?>
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= $user->name ?></p>
                    </div>
                </div>
                <?= CustomerInfo::widget(['userId' => $user->id])?>
                <a href="<?= Url::to(['users/view', 'id' => $task->user->id]) ?>" class="link-regular">Смотреть
                    профиль</a>
            </div>
        </div>

        <?php if ($task->status === Task::STATUS_IN_WORK): ?>
            <?php if ($task->executor_id === Yii::$app->user->getId()
                || $task->user_id === Yii::$app->user->getId()): ?>
                <div id="chat-container">
                    <chat class="connect-desk__chat" task="<?php echo $task->id ?>"></chat>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <section class="modal response-form form-modal" id="response-form">
            <?= $this->render('_responseForm', [
                'responseForm' => $responseForm
            ])
            ?>
        </section>
        <section class="modal completion-form form-modal" id="complete-form">
            <?= $this->render('_completeForm', [
                'completionForm' => $completionForm
            ]) ?>
        </section>
        <section class="modal form-modal refusal-form" id="refuse-form">
            <?= $this->render('_refuseForm', [
                'task' => $task
            ]) ?>
        </section>
</div>
<?php if ($task->address): ?>
<?= $this->render('_map', [
    'points' => $address['yMapsPoints']
]) ?>
<?php endif; ?>
<?php $this->registerJsFile('/js/messenger.js'); ?>
