<?php
/**
 * @var object $filterForm
 * @var object $categories
 */

use frontend\models\Categories;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'search-task__form'],
    'fieldConfig' => [
        'labelOptions' => ['class' => 'checkbox__legend'],
        'options' => ['tag' => false]
    ]
]);

?>

<fieldset class="search-task__categories">
    <legend>Категории</legend>
    <?= $form->field($filterForm, 'category_ids', ['template' => '{input}'])
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
    <?= $form->field($filterForm, 'isFree', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>Сейчас свободен</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
    <?= $form->field($filterForm, 'online', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>Сейчас онлайн</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
    <?= $form->field($filterForm, 'review', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>Есть отзывы</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
    <?= $form->field($filterForm, 'favorite', [
        'template' => '<label class="checkbox__legend">
                                    {input}
                            <span>В избранном</span>
                        </label>',
    ])->checkbox([
        'class' => 'visually-hidden checkbox__input',
    ],
        false); ?>
</fieldset>

<?= $form->field($filterForm, 'nameSearch', [
    'template' => "{label}\n{input}\n",
    'options' => ['class' => 'field-container'],
    'labelOptions' => ['class' => 'search-task__name']
])->input('text', ['class' => 'input-middle input']) ?>



<fieldset class="search-task__categories" style="flex-direction: row-reverse; justify-content: space-between">
    <?= Html::submitButton('Поиск', [
        'type' => 'submit',
        'class' => 'button'
    ]) ?>

    <a href="<?= Url::to(['users']) ?>">
        <?= Html::button('Очистить', [
            'type' => 'button',
            'class' => 'button reset-button'
        ]) ?>
    </a>
</fieldset>

<?php ActiveForm::end() ?>


