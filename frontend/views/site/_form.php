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
        <?= Html::submitButton('Войти', ['class' => 'button', 'style' => ['margin-top' => '12px']]) ?>
        <div style="margin-bottom: 4px">Вход через соц. сети:</div>
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
        ]) ?>
    <?= $form->errorSummary($model) ?>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

    <button class="form-modal-close" type="button">Закрыть</button>
</section>
