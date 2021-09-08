<?php

/**
 * @var $model object loginForm data
 */

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;

?>
<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <?php Pjax::begin() ?>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options' => [
                'class' => '',
                'data' => ['pjax' => true]
        ]
    ]) ?>

    <?= $form->field($model, 'email', [
            'template' => "<p>{label}\n{input}\n</p>",
            'labelOptions' => ['class' => 'form-modal-description'],
            'inputOptions' => ['class' => 'enter-form-email input input-middle']
    ]) ?>
    <?= $form->field($model, 'password', [
        'template' => "<p>{label}\n{input}\n</p>",
        'labelOptions' => ['class' => 'form-modal-description'],
        'inputOptions' => [
                'class' => 'enter-form-email input input-middle',
                'type' => 'password'
        ]
    ]) ?>
    <?= $form->errorSummary($model) ?>
    <?= Html::submitButton('Войти', ['class' => 'button']) ?>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<!---->
<!--<section class="modal enter-form form-modal" id="enter-form">-->
<!--    <h2>Вход на сайт</h2>-->
<!--    <form action="#" method="post">-->
<!--        <p>-->
<!--            <label class="form-modal-description" for="enter-email">Email</label>-->
<!--            <input class="enter-form-email input input-middle" type="email" name="enter-email" id="enter-email">-->
<!--        </p>-->
<!--        <p>-->
<!--            <label class="form-modal-description" for="enter-password">Пароль</label>-->
<!--            <input class="enter-form-email input input-middle" type="password" name="enter-email" id="enter-password">-->
<!--        </p>-->
<!--        <button class="button" type="submit">Войти</button>-->
<!--    </form>-->
<!--    <button class="form-modal-close" type="button">Закрыть</button>-->
<!--</section>-->
