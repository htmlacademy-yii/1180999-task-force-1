<?php
/**
 * @var \frontend\models\Categories[] $categories
 * @var \frontend\models\TasksSearch $modelForm
 * @var array[] $items
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\models\forms\TaskFilterForm;

?>
<?php
$interval = TaskFilterForm::getIntervalName();
$items = [];

foreach ($categories as $category) {
    $items[] = $category->name;
}
$items = array_combine(range(1, count($items)), array_values($items));
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'search-task__form'],
    'fieldConfig' => [
        'labelOptions' => ['class' => 'checkbox__legend'],
        'options' => ['tag' => false]
        ]
    ])
?>
    <fieldset class="search-task__categories">
        <legend>Категории</legend>
        <?= $form->field($modelForm, 'category_ids', ['template' => '{input}'])
            ->checkboxList($items, [
                'item' => function ($index, $label, $name, $checked, $value)  {
                    $checked = $checked ? 'checked':'';
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

    <div class="field-container">
        <?= $form->field($modelForm, 'interval')->dropDownList($interval) ?>
    </div>
    <div class="field-container">
        <label class="search-task__name" for="9">Поиск по названию</label>
        <?= $form->field($modelForm, 'search')->input('text')->label(false) ?>
    </div>
<?= Html::submitButton('Поиск', [
    'type' => 'submit',
    'class' => 'button'
]) ?>

<?php ActiveForm::end() ?>