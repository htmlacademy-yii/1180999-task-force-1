<?php
/* @var $this yii\web\View */
/**
 * @var $users object объект данных исполнителей
 */
?>

<div class="main-container page-container">
    <section class="user__search">
        <?php foreach ($users as $user): ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="user.html"><img src="./<?= $user->avatarFile->path ?>" width="65" height="65"></a>
                    <span>17 заданий</span>
                    <span>6 отзывов</span>
                </div>
                <div class="feedback-card__top--name user__search-card">
                    <p class="link-name"><a href="user.html" class="link-regular"><?= $user->name ?></a></p>
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
            <form class="search-task__form" name="users" method="post" action="#">
                <fieldset class="search-task__categories">
                    <legend>Категории</legend>

                    <label class="checkbox__legend">
                        <input class="visually-hidden checkbox__input" type="checkbox" name="" value="" checked disabled>
                        <span>Курьерские услуги</span>
                    </label>

                </fieldset>
                <fieldset class="search-task__categories">
                    <legend>Дополнительно</legend>
                    <label class="checkbox__legend">
                        <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                        <span>Сейчас свободен</span>
                    </label>
                    <label class="checkbox__legend">
                        <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                        <span>Сейчас онлайн</span>
                    </label>
                    <label class="checkbox__legend">
                        <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                        <span>Есть отзывы</span>
                    </label>
                    <label class="checkbox__legend">
                        <input class="visually-hidden checkbox__input" type="checkbox" name="" value="">
                        <span>В избранном</span>
                    </label>
                </fieldset>
                <label class="search-task__name" for="110">Поиск по имени</label>
                <input class="input-middle input" id="110" type="search" name="q" placeholder="">
                <button class="button" type="submit">Искать</button>
            </form>
        </div>
    </section>
</div>