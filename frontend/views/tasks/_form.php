<?php
/**
 * @var \frontend\models\Categories[] $categories
 * @var \frontend\models\TasksSearch $modelForm
 * @var array[] $items
 */

use frontend\models\Categories;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\models\forms\TaskFilterForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'search-task__form'],
    'fieldConfig' => [
        'labelOptions' => ['class' => 'checkbox__legend']
    ]
])
?>
    <fieldset class="search-task__categories">
        <legend>Категории</legend>
        <?= $form->field($modelForm, 'category_ids', ['template' => '{input}'])
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
        <?= $form->field($modelForm, 'noExecutor', [
            'template' => '<label class="checkbox__legend">{input}
                  <span>Без исполнителя</span>
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

<?= Html::submitButton('Поиск', [
    'type' => 'submit',
    'class' => 'button'
]) ?>

<?php ActiveForm::end() ?>