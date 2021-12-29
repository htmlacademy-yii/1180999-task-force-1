<?php
/**
 * @var TasksSearch $modelForm
 * @var array[] $items
 */

use frontend\models\Categories;
use frontend\models\forms\TaskFilterForm;
use frontend\models\TasksSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'search-task__form'],
    'fieldConfig' => [
        'options' => ['tags' => false],
        'labelOptions' => ['class' => 'checkbox__legend']
    ]
])
?>
    <fieldset class="search-task__categories">
        <legend>Категории</legend>
        <?= $form->field($modelForm, 'category_ids', [
            'template' => '{input}'
        ])
            ->checkboxList(Categories::find()->select(['name', 'id'])->indexBy('id')->column(), [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = $checked ? 'checked' : '';
                    return "
                    <label class='checkbox__legend' for='{$index}'>
                        <input class=\"visually-hidden checkbox__input\" id='{$index}' type='checkbox' name='{$name}' value='{$value}' $checked >
                        <span>{$label}</span>
                    </label>";
                }])->label(false);
        ?>
    </fieldset>

    <fieldset class="search-task__categories">
        <legend>Дополнительно</legend>
        <?= $form->field($modelForm, 'noResponses', [
            'template' => '<label class="checkbox__legend">{input}
                  <span>Без откликов</span>
                </label>'])
            ->checkbox(['class' => 'visually-hidden checkbox__input'], false) ?>
        <?= $form->field($modelForm, 'remote', [
            'template' => '<label class="checkbox__legend">{input}
                  <span>Удаленная работа</span>
                </label>'])
            ->checkbox(['class' => 'visually-hidden checkbox__input'], false) ?>
    </fieldset>


<?= $form->field($modelForm, 'interval', [
    'template' => "{label}\n{input}\n",
    'options' => [
        'class' => 'field-container'
    ],
    'labelOptions' => ['class' => 'search-task__name'],
    'inputOptions' => ['class' => 'multiple-select input']
])->dropDownList(TaskFilterForm::getIntervalName()) ?>


<?= $form->field($modelForm, 'search', [
    'template' => "{label}\n{input}\n",
    'options' => ['class' => 'field-container'],
    'labelOptions' => ['class' => 'search-task__name']
])->input('text', ['class' => 'input-middle input']) ?>

    <fieldset class="search-task__categories" style="flex-direction: row-reverse; justify-content: space-between">
        <?= Html::submitButton('Поиск', [
            'type' => 'submit',
            'class' => 'button'
        ]) ?>

        <?= Html::a(Html::button('Очистить', [
            'type' => 'button',
            'class' => 'button reset-button'
        ]), Url::to(['tasks/index'])) ?>
    </fieldset>


<?php ActiveForm::end() ?>