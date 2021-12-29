<?php

use frontend\models\Tasks;
use frontend\widgets\notifications\MessengerWidget;
use frontend\widgets\rating\RatingWidget;
use frontend\widgets\status\StatusWidget;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * @var $model Tasks
 */

?>
        <div class="new-task__card">
            <div class="new-task__title">
                <?= Html::a('<h2>' . mb_strimwidth($model->name, '0', '30', '...') . '</h2>',
                    Url::to(['tasks/view', 'id' => $model->id]),
                    ['class' => 'link-regular']
                ) ?>
                <?= Html::a('<p>' . $model->category->name . '</p>',
                    Url::to('/tasks?TaskFilterForm%5Bcategory_ids%5D=' . $model->category_id),
                    ['class' => 'new-task__type link-regular']
                ) ?>
            </div>
            <div class="task-status <?= StatusWidget::widget(['status' => $model->status]) ?>">
                <?= $model->status ?></div>
            <p class="new-task_description">
                <?= mb_strimwidth($model->description, 0, 90, "..."); ?>
            </p>
            <?php if ($model->executor): ?>
                <div class="feedback-card__top">
                    <?= Html::a(Html::img($model->executor->avatarFile->path ?? '/img/no-photos.png', [
                        'width' => 36,
                        'height' => 36,
                        'alt' => 'Аватар исполнителя',
                    ]), Url::to(['users/view', 'id' => $model->executor_id])) ?>
                    <div class="feedback-card__top--name my-list__bottom">
                        <p class="link-name">
                            <?= Html::a($model->executor->name,
                                Url::to(['users/view', 'id' => $model->executor_id]),
                                ['class' => 'link-regular']
                            ) ?>
                        </p>
                        <?= MessengerWidget::widget(['task_id' => $model->id]) ?>
                        <?= RatingWidget::widget(['rating' => $model->executor->calcRatingScore()]) ?>
                    </div>
                </div>

            <?php endif; ?>
        </div>

