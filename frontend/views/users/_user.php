<?php

/**
 * @var $model Users;
 */

use frontend\models\Users;
use frontend\services\CalcRatingScore;
use frontend\widgets\executorInfo\ExecutorInfo;
use frontend\widgets\rating\RatingWidget;
use frontend\widgets\timeFormatter\TimeFormatterWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="feedback-card__top">
    <div class="user__search-icon">
        <?= ExecutorInfo::widget(['id' => $model->id]) ?>
    </div>
    <div class="feedback-card__top--name user__search-card">
        <p class="link-name">
            <?= Html::a($model->name,
                Url::to(['users/view', 'id' => $model->id]),
                ['class' => 'link-regular']
            ) ?>
        </p>
        <?= RatingWidget::widget(['rating' => CalcRatingScore::run($model->id)]) ?>
        <p class="user__search-content">
            <?= $model->about_me ?>
        </p>
    </div>
    <?= TimeFormatterWidget::widget([
        'time' => $model->last_active_time,
        'format' => TimeFormatterWidget::USER_FORMAT])
    ?>
</div>
<div class="link-specialization user__search-link--bottom">
    <?php foreach ($model->categories as $spec): ?>
        <?= Html::a($spec->category->name,
            Url::to(['tasks/index', 'TaskFilterForm' => [
                'category_ids' => $spec->category_id
            ]]), [
                'class' => 'link-regular'
            ]
        ) ?>

    <?php endforeach; ?>
</div>
<div class="separator"></div>

