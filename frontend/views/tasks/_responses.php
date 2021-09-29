<?php
/**
 * @var object $task Данные задачи
 * @var object $responseForm Форма добавления отклика
 */

use frontend\models\Responses;
use yii\helpers\Html;
use yii\helpers\Url;

?>
    <div class="content-view__feedback">
        <h2>Отклики <span>(<?= count($task->responses) ?>)</span></h2>
        <div class="content-view__feedback-wrapper">

            <?php foreach (Responses::find()
                               ->where(['task_id' => $task->id])
                               ->orderBy('dt_add DESC')
                               ->all() as $response): ?>
                <div class="content-view__feedback-card">
                    <div class="feedback-card__top">
                        <a href="<?= Url::to(['users/view', 'id' => $response->executor_id]) ?>">
                            <img src="<?= $user->avatarFile->path ?? 'https://via.placeholder.com/1' ?>"
                                 width="55" height="55"></a>
                        <div class="feedback-card__top--name">
                            <p><a href="<?= Url::to(['users/view', 'id' => $response->executor_id]) ?>"
                                  class="link-regular"><?= $response->executor->name ?></a></p>
                            <span></span><span></span><span></span><span></span><span
                                    class="star-disabled"></span>
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
                        <?php if (!$response->refuse): ?>
                        <a class="button__small-color response-button button"
                           type="button">Подтвердить</a>

                        <?= Html::a('Отказать',
                            Url::to(['tasks/refuse', 'id' => $response->id]),
                            ['class' => 'button__small-color refusal-button button']
                        ) ?>
                        <?php endif; ?>

                        <?= Html::a('Accept',
                            Url::to(['tasks/accept', 'id' => $response->id])
                        ) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>