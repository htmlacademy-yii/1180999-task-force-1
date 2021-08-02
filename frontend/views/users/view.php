<?php
/**
 * @var object $user пользователь
 * @var object $reviews отзывы о пользователе
 */

use yii\helpers\Url;

?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <img src="<?= $user->avatarFile->path ?? 'https://via.placeholder.com/1.png' ?>" width="120" height="120" alt="Аватар пользователя">
                <div class="content-view__headline">
                    <h1><?= $user->name ?></h1>
                    <p><?= $user->city->name ?></p>
                    <div class="profile-mini__name five-stars__rate">
                        <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                        <b>4.25</b>
                    </div>
                    <b class="done-task">Выполнил 5 заказов</b><b class="done-review">Получил 6 отзывов</b>
                </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span>Был на сайте <?= $user->last_active_time ?></span>
                    <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <p><?= $user->about_me ?></p>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <h3 class="content-view__h3">Специализации</h3>
                    <div class="link-specialization">
                        <a href="../views/site/browse.html" class="link-regular">Ремонт</a>
                        <a href="../views/site/browse.html" class="link-regular">Курьер</a>
                        <a href="../views/site/browse.html" class="link-regular">Оператор ПК</a>
                    </div>
                    <h3 class="content-view__h3">Контакты</h3>
                    <div class="user__card-link">
                        <a class="user__card-link--tel link-regular" href="#"><?= $user->phone ?></a>
                        <a class="user__card-link--email link-regular" href="#"><?= $user->email ?></a>
                        <a class="user__card-link--skype link-regular" href="#"><?= $user->skype ?></a>
                    </div>
                </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <a href="#"><img src="./img/rome-photo.jpg" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="./img/smartphone-photo.png" width="85" height="86" alt="Фото работы"></a>
                    <a href="#"><img src="./img/dotonbori-photo.png" width="85" height="86" alt="Фото работы"></a>
                </div>
            </div>
        </div>
        <div class="content-view__feedback">
            <h2>Отзывы<span> (<?= count($reviews) ?>)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">

                <?php foreach ($reviews as $review): ?>
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание
                        <a href="<?= Url::to(['tasks/view', 'id' => $review->task_id]) ?>" class="link-regular">
                            <?= $review->task->name ?></a></p>
                    <div class="card__review">
                        <a href="">
                            <img src="<?= $review->user->avatarFile ?? 'https://via.placeholder.com/1.png' ?>" width="55" height="54">
                        </a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="<?= Url::to(['users/view', 'id' => $review->user_id])?>" class="link-regular">
                                    <?= $review->user->name ?></a></p>
                            <p class="review-text">
                                <?= $review->text ?>
                            </p>
                        </div>
                        <div class="card__review-rate">
                            <p class="five-rate big-rate"><?= $review->score ?><span></span></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">

        </div>
    </section>
</div>