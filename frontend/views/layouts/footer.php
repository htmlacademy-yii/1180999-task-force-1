<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="main-container page-footer__container">
    <div class="page-footer__info">
        <p class="page-footer__info-copyright">
            © 2019 - <?= date('Y') ?>, ООО «ТаскФорс»
            Все права защищены
        </p>
        <p class="page-footer__info-use">
            «TaskForce» — это сервис для поиска исполнителей на разовые задачи.
            mail@taskforce.com
        </p>
    </div>
    <div class="page-footer__links">
        <ul class="links__list">
            <li class="links__item">
                <?= Html::a('Задания', Url::to(['tasks/index'])) ?>
            </li>
            <?php if (!Yii::$app->user->isGuest): ?>
                <li class="links__item">
                    <?= Html::a('Мой профиль', Url::to(
                        ['users/view', 'id' => Yii::$app->user->identity->getId()]
                    )) ?>
                </li>
            <?php endif; ?>
            <li class="links__item">
                <?= Html::a('Исполнители', Url::to(['users/index'])) ?>
            </li>
            <?php if (Yii::$app->user->isGuest): ?>
                <li class="links__item">
                    <?= Html::a('Регистрация', Url::to(['sign-up/index'])) ?>
                </li>
            <?php endif; ?>
            <?php if (!Yii::$app->user->isGuest): ?>
                <li class="links__item">
                    <?= Html::a('Создать', Url::to(['tasks/create'])) ?>
                </li>
            <?php endif; ?>
            <li class="links__item">
                <a href="#">Справка</a>
            </li>
        </ul>
    </div>
    <div class="page-footer__copyright">
        <a>
            <img class="copyright-logo"
                 src="/img/academy-logo.png"
                 width="185" height="63"
                 alt="Логотип HTML Academy">
        </a>
    </div>
    <?php if (Yii::$app->request->url === '/sign-up'): ?>
        <div class="clipart-woman">
            <img src="./img/clipart-woman.png" width="238" height="450">
        </div>
        <div class="clipart-message">
            <div class="clipart-message-text">
                <h2>Знаете ли вы, что?</h2>
                <p>После регистрации вам будет доступно более
                    двух тысяч заданий из двадцати разных категорий.</p>
                <p>В среднем, наши исполнители зарабатывают
                    от 500 рублей в час.</p>
            </div>
        </div>
    <?php endif; ?>
</div>
