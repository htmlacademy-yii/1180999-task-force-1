<?php
/**
 * @var object $modelForm
 * @var object $categories
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\models\forms\UserFilterForm;

$items = [];

foreach ($categories as $category) {
    $items[] = $category->name;
}
$items = array_combine(range(1, count($items)), array_values($items));
?>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'post',
    'options' => ['class' => 'search-task__form'],
    'fieldConfig' => [
        'labelOptions' => ['class' => 'checkbox__legend'],
        'options' => ['tag' => false]
    ]
]);

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
    <?= $form->field($modelForm, 'isFree', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>Сейчас свободен</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
    <?= $form->field($modelForm, 'online', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>Сейчас онлайн</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
    <?= $form->field($modelForm, 'review', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>Есть отзывы</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
    <?= $form->field($modelForm, 'favorite', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>В избранном</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
</fieldset>

    <label class="search-task__name">Поиск по имени</label>
    <?= $form->field($modelForm, 'nameSearch')->input('text')->label(false) ?>


<?= Html::submitButton('Поиск', [
    'type' => 'submit',
    'class' => 'button mt-3'
]) ?>

<?php ActiveForm::end() ?>


