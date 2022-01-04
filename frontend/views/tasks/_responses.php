<?php
/**
 * @var object $task Данные задачи
 * @var object $responseForm Форма добавления отклика
 */

use frontend\models\Responses;
use frontend\services\CalcRatingScore;
use frontend\widgets\rating\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<h2>Отклики <span>(<?= count($task->responses) ?>)</span></h2>
<div class="content-view__feedback-wrapper">

    <?php foreach ($task->responses as $response): ?>
        <div class="content-view__feedback-card">
            <div class="feedback-card__top">
                <?= Html::a(Html::img($response->executor->avatarFile->path ?? '/img/no-photos.png', [
                    'width' => 55,
                    'height' => 55,
                    'alt' => 'Аватар исполнителя',
                ]), Url::to(['users/view', 'id' => $response->executor_id])) ?>
                <div class="feedback-card__top--name">
                    <p>
                        <?= Html::a($response->executor->name,
                            Url::to(['users/view', 'id' => $response->executor_id]),
                        ['class' => 'link-regular'])
                        ?>
                    </p>
                    <?= RatingWidget::widget(['rating' => CalcRatingScore::run($response->executor_id)]) ?>

                </div>
                <span class="new-task__time"><?= Yii::$app->formatter->format($response->dt_add, 'relativeTime') ?></span>
            </div>
            <div class="feedback-card__content">
                <p>
                    <?= $response->description ?>
                </p>
                <span><?= $response->price ?> ₽</span>
            </div>
            <div class="feedback-card__actions">
                <?php if (!$response->refuse): ?>

                    <?= Html::a('Подтвердить',
                        Url::to(['tasks/accept', 'id' => $response->id,]),
                        ['class' => 'button__small-color response-button button']
                    ) ?>

                    <?= Html::a('Отказать',
                        Url::to(['tasks/refuse', 'id' => $response->id]),
                        ['class' => 'button__small-color refusal-button button']
                    ) ?>
                <?php endif; ?>


            </div>
        </div>
    <?php endforeach; ?>
</div>