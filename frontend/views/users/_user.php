<?php

/**
 * @var $model \frontend\models\Users;
 */

use frontend\widgets\rating\RatingWidget;
use frontend\widgets\timeFormatter\TimeFormatterWidget;
use yii\helpers\Url;

?>

<div class="feedback-card__top">
    <div class="user__search-icon">
        <a href="user.html"><img src="./img/man-glasses.jpg" width="65" height="65"></a>
        <span>17 заданий</span>
        <span>6 отзывов</span>
    </div>
    <div class="feedback-card__top--name user__search-card">
        <p class="link-name">
            <a href="<?= Url::to(['users/view', 'id' => $model->id]) ?>" class="link-regular"><?= $model->name ?></a>
        </p>
        <?= RatingWidget::widget(['rating' => $model->calcRatingScore()]) ?>
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
    <a href="../views/site/browse.html" class="link-regular">Ремонт</a>
    <a href="../views/site/browse.html" class="link-regular">Курьер</a>
    <a href="../views/site/browse.html" class="link-regular">Оператор ПК</a>
</div>
<div class="separator"></div>

