<?php

/**
 * @var $model Tasks;
 */

use frontend\widgets\timeFormatter\TimeFormatterWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Tasks;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <?= Html::a("<h2>{$model->name}</h2>",
                    Url::to(['tasks/view', 'id' => $model->id]),
                    ['class' => 'link-regular']
        )?>
        <?= Html::a("<p>{$model->category->name }</p>",
            Url::to(['tasks/index', 'TaskFilterForm' => ['category_ids' => $model->category_id]]),
            ['class' => 'new-task__type link-regular']
        )?>
    </div>
    <div class="new-task__icon new-task__icon--<?= $model->category->code?>"></div>
    <p class="new-task_description">
        <?= mb_strimwidth($model->description, 0, 90, "..."); ?>
    </p>
    <b class="new-task__price new-task__price--<?= $model->category->code?>"><?= $model->cost ? $model->cost.'₽': ''?><b> </b></b>

    <p class="new-task__place"><?= $model->address ?? ' - '?><br></p>
    <?= TimeFormatterWidget::widget([
            'time' => $model->dt_add,
            'format' => TimeFormatterWidget::TASK_FORMAT
    ]) ?>
</div>