<?php
/* @var $this yii\web\View */
/**
 * @var $users object объект данных исполнителей
 * @var $modelForm object данные формы фильтра
 * @var $categories object список категорий
 */

use yii\helpers\Url;

?>
<div class="main-container page-container">
    <section class="user__search">
        <?php foreach ($users as $user): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="<?= $user->id ?>"><img src="<?= $user->avatarFile->path ?? '/img/user-man.jpg' ?>" width="65" height="65" alt=""></a>
                    <span>17 заданий</span>
                    <span>6 отзывов</span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>" class="link-regular">
                            <?= $user->name ?>
                        </a>
                    </p>
                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                    <b>4.25</b>
                    <p class="user__search-content">
                        <?= $user->about_me ?>
                    </p>
                </div>
                <span class="new-task__time"><?= $user->last_active_time ?></span>
            </div>
            <div class="link-specialization user__search-link--bottom">
                <a href="../views/site/browse.html" class="link-regular">Ремонт</a>
                <a href="../views/site/browse.html" class="link-regular">Курьер</a>
                <a href="../views/site/browse.html" class="link-regular">Оператор ПК</a>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">

            <?= $this->render('_form', [
                'modelForm' => $modelForm,
                'categories' => $categories
            ]) ?>

        </div>
    </section>
</div>