<?php
use yii\helpers\Html;

use yii\helpers\Url;

if (Yii::$app->user->isGuest): ?>

    <?= Html::a('<span>Вход</span>',
        '#',
        [
            'class' => 'header__account-enter open-modal',
            'data-for' => 'enter-form'
        ]
    ) ?>
    или
    <?= Html::a('Регистрация',
        Url::to(['sign-up/index']),
        ['class' => 'header__account-registration']
    ) ?>

<?php else: ?>
    <?= Html::a('Мои задания', Url::to(['mylist/new']),
    ) ?>
    &nbsp;
    <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
        </svg>
        Выйти (' . Yii::$app->user->identity->name . ')', Url::to(['site/logout']),
    ) ?>
<?php endif; ?>
<?php if (Yii::$app->session->getFlash('errors')): ?>
<div class="error_message--Registration">
    <span>Ошибка авторизации,<br>email уже существует</span>
</div>
<?php endif; ?>