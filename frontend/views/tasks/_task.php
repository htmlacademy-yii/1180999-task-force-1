<?php

/**
 * @var $model Tasks;
 */

use yii\helpers\Url;
use frontend\models\Tasks;

?>

<div class="new-task__card">
    <div class="new-task__title">
        <a href="<?= Url::to(['tasks/view', 'id' => $model->id]) ?>" class="link-regular"><h2><?= $model->name ?></h2>
        </a>
        <a class="new-task__type link-regular" href="
        <?= Url::to(['tasks/index', 'TaskFilterForm' => ['category_ids' => $model->category_id]]) ?>
            "><p><?= $model->category->name ?></p></a>
    </div>
    <div class="new-task__icon new-task__icon--<?= $model->category->code?>"></div>
    <p class="new-task_description">
        <?= mb_strimwidth($model->description, 0, 90, "..."); ?>
    </p>
    <b class="new-task__price new-task__price--<?= $model->category->code?>"><?= $model->cost ? $model->cost.'₽': ''?><b> </b></b>
    <p class="new-task__place"><?= $model->location ?? 'Санкт-Петербург, Центральный район' ?></p>
    <span class="new-task__time"><?= Yii::$app->formatter->format($model->dt_add, 'relativeTime') ?></span>
</div>