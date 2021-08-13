<?php
/**
 * @var object $task данные задачи
 */

use yii\helpers\Url;
use frontend\models\Files;

?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="content-view__card">
            <div class="content-view__card-wrapper">
                <div class="content-view__header">
                    <div class="content-view__headline">
                        <h1><?= $task->name ?></h1>
                        <span>Размещено в категории
                            <a href="<?= Url::to(['tasks/index', 'TaskFilterForm' => ['category_ids' => $task->category_id]]) ?>"
                               class="link-regular">
                                <?= $task->category->name ?>
                            </a>
                            <?= $task->dt_add ?>
                        </span>
                    </div>
                    <b class="new-task__price new-task__price--clean content-view-price"><?= $task->cost ?><b> ₽</b></b>
                    <div class="new-task__icon new-task__icon--clean content-view-icon"></div>
                </div>
                <div class="content-view__description">
                    <h3 class="content-view__h3">Общее описание</h3>
                    <p>
                        <?= $task->description ?>
                    </p>
                </div>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>

                    <?php foreach ($task->tasksFiles as $file): ?>
                        <a href="uploads/<?= Files::findOne($file->file_id)->path ?>">
                            <?= Files::findOne($file->file_id)->path ?>
                        </a>
                    <?php endforeach; ?>

                </div>
                <div class="content-view__location">
                    <h3 class="content-view__h3">Расположение</h3>
                    <div class="content-view__location-wrapper">
                        <div class="content-view__map">
                            <a href="#"><img src="../img/map.jpg" width="361" height="292"
                                             alt="Москва, Новый арбат, 23 к. 1"></a>
                        </div>
                        <div class="content-view__address">
                            <span class="address__town">Москва</span><br>
                            <span>Новый арбат, 23 к. 1</span>
                            <p>Вход под арку, код домофона 1122</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-view__action-buttons">
                <button class=" button button__big-color response-button open-modal"
                        type="button" data-for="response-form">Откликнуться
                </button>
                <button class="button button__big-color refusal-button open-modal"
                        type="button" data-for="refuse-form">Отказаться
                </button>
                <button class="button button__big-color request-button open-modal"
                        type="button" data-for="complete-form">Завершить
                </button>
            </div>
        </div>
        <div class="content-view__feedback">
            <h2>Отклики <span>(<?= count($task->responses)?>)</span></h2>
            <div class="content-view__feedback-wrapper">

                <?php foreach ($task->responses as $response): ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <a href="<?= Url::to(['users/view', 'id' => $response->executor_id])?>">
                            <img src="<?= $user->avatarFile->path ?? 'https://via.placeholder.com/1.png' ?>" width="55" height="55"></a>
                        <div class="feedback-card__top--name">
                            <p><a href="<?= Url::to(['users/view', 'id' => $response->executor_id])?>" class="link-regular"><?= $response->executor->name ?></a></p>
                            <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                            <b>4.25</b>
                        </div>
                        <span class="new-task__time"><?= $response->dt_add ?></span>
                    </div>
                    <div class="feedback-card__content">
                        <p>
                            <?= $response->description ?>
                        </p>
                        <span><?= $response->price ?> ₽</span>
                    </div>
                    <div class="feedback-card__actions">
                        <a class="button__small-color response-button button"
                           type="button">Подтвердить</a>
                        <a class="button__small-color refusal-button button"
                           type="button">Отказать</a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <div class="profile-mini__top">
                    <img src="../img/man-brune.jpg" width="62" height="62" alt="Аватар заказчика">
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= $task->user->name ?></p>
                    </div>
                </div>
                <p class="info-customer"><span>12 заданий</span><span class="last-">2 года на сайте</span></p>
                <a href="<?= Url::to(['users/view', 'id' => $task->user->id]) ?>" class="link-regular">Смотреть профиль</a>
            </div>
        </div>
        <div id="chat-container">
            <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
            <chat class="connect-desk__chat"></chat>
        </div>
    </section>
</div>