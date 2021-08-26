<?php
/**
 * @var $model object данные формы регистрации
 * @var $emailError string ошибка уникальности емайла
 */

use frontend\models\Cities;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
    <div class="main-container page-container">
        <section class="registration__user">
            <h1>Регистрация аккаунта</h1>
            <div class="registration-wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'options' => [
                        'class' => 'registration__user-form form-create'
                    ]
                ]);
                ?>

                <?= $form->field($model, 'email', [
                    'template' => "
                            {label}\n 
                            {input}\n
                            <span class='registration__text-error'>{error}</span>\n",
                    'inputOptions' => ['type' => 'email', 'class' => 'input textarea', 'placeholder' => 'kumarm@mail.ru', 'width' => '100%'],
                    'options' => ['class' => 'field-container field-container--registration']
                ])?>

                <?= $form->field($model, 'name', [
                    'template' => "
                            {label}\n 
                            {input}\n
                            <span class='registration__text-error'>{error}</span>",
                    'inputOptions' => ['class' => 'input textarea', 'placeholder' => 'Мамедов Кумар'],
                    'options' => ['class' => 'field-container field-container--registration']
                ]) ?>

                <?= $form->field($model, 'city', [
                    'template' => "
                        {label}\n
                        {input}\n
                        <span class='registration__text-error'>{error}</span>",
                    'inputOptions' => ['class' => 'multiple-select input town-select registration-town'],
                    'options' => ['class' => 'field-container field-container--registration']
                ])->dropDownList(Cities::find()->select(['name', 'id'])->indexBy('id')->column()) ?>

                <?= $form->field($model, 'password', [
                    'template' => "
                        {label}\n
                        {input}\n
                        <span class='registration__text-error'>{error}</span>",
                    'inputOptions' => ['type' => 'password', 'class' => 'input textarea'],
                    'options' => ['class' => 'field-container field-container--registration']
                ]) ?>
                <?= Html::submitButton('Создать аккаунт', ['class' => 'button button__registration']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </section>
    </div>
