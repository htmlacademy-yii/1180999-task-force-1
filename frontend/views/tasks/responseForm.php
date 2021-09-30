<?php

/**
 * @var $responseForm object Модель формы создания отклика
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<h2>Отклик на задание</h2>
<?php Pjax::begin() ?>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'options' => [
        'data' => ['Pjax' => true]
    ]

]) ?>
<?= $form->field($responseForm, 'price', [
    'template' => "{label}\n{input}\n
                               <span style='display: block;
                                            margin-bottom: 10px;
                                            color: #FF116E;
                                            font-family: Roboto, sans-serif;
                                            font-weight: 300;
                                            font-size: 12px;'>{error}</span>",
    'labelOptions' => [
        'class' => 'form-modal-description field-container',
    ],
    'inputOptions' => [
        'class' => 'response-form-payment input input-middle input-money'
    ]

])->error() ?>
<?= $form->field($responseForm, 'description', [
    'template' => "<p>{label}\n{input}\n</p>",
    'labelOptions' => [
        'class' => 'form-modal-description',
    ],
    'inputOptions' => [
        'class' => 'input text-area',
        'rows' => 4
    ]

])->textarea() ?>
<?= Html::submitButton('Отправить', ['class' => 'button modal-button']) ?>
<?php ActiveForm::end() ?>
<?php Pjax::end() ?>

<?= Html::button('Закрыть', ['class' => 'form-modal-close']) ?>