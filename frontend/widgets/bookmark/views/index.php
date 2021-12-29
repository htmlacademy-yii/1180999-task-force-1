<?php

/**
 * @var Users $user
 * @var string $marker
 */

use frontend\models\Users;
use frontend\widgets\timeFormatter\TimeFormatterWidget;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="content-view__headline user__card-bookmark user__card-bookmark<?= $marker ?>">
    <?= TimeFormatterWidget::widget([
        'time' => $user->last_active_time,
        'format' => TimeFormatterWidget::USER_FORMAT
    ]) ?>
    <?= Html::a('<b></b>',
        Url::to(['users/add-bookmark', 'favorite_id' => $user->id])
    )?>
</div>

