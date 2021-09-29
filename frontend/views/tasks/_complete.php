<?php

/**
 * @var $completionForm object модель формы завершения задачи
 */

use frontend\models\forms\CompletionForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>
    <h2>Завершение задания</h2>

<?php Pjax::begin() ?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data' => ['Pjax' => true]
    ]
]) ?>
    <p class="form-modal-description">
<?= $form->field($completionForm, 'completeness', [
        'options' => [
                'tag' => false
        ]
])
    ->radioList(CompletionForm::getCompleteFlag(),
        [
            'item' => function ($index, $label, $name) {
                $class = ['yes', 'difficult'];
                return "<input class=\"visually-hidden completion-input completion-input--{$class[$index]}\"
							id='{$index}'
							type='radio'
							name='{$name}'
							value='{$index}' >
							<label class=\"completion-label completion-label--{$class[$index]}\" for='{$index}'>{$label}</label>";
            }
        ])
?>
    </p>

<?= $form->field($completionForm, 'description', [
        'template' => "<p>{label}\n{input}\n</p>",
        'labelOptions' => [
                'class' => 'form-modal-description'
        ],
        'inputOptions' => [
                'class' => 'input textarea',
                'rows' => '4',
                'placeholder' => 'Введите свой текст'
        ]
])->textarea() ?>
    <p class="form-modal-description">
        <?= $form->field($completionForm, 'rating', [
            'options' => [
                'tag' => false
            ],
        ])->hiddenInput([
            'id' => 'rating',
            'name' => 'rating',
        ]); ?>
    <div class="feedback-card__top--name completion-form-star">
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
    </div>
    </p>

<?= $form->errorSummary($completionForm) ?>
<?= Html::submitButton('Отправить', [
        'class' => 'button modal-button'
]) ?>

<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<button class="form-modal-close" type="button">Закрыть</button>
