<?php

use frontend\models\Categories;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\forms\TaskCreate */
/* @var $form ActiveForm */
?>

<div class="main-container page-container">
    <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">

            <?php $form = ActiveForm::begin([
                    'id' => 'task-form',
                    'action' => ['create'],
                    'options' => [
                        'class' => 'create__task-form form-create',
                        'method' => 'post',
                        'enctype' => 'multipart/form-data'
                    ],
                ]
            ); ?>

            <?= $form->field($model, 'name', [
                'template' => "{label}\n{input}\n<span>{hint}</span>",
                'options' => [
                    'class' => 'field-container'
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'placeholder' => 'Повесить полку'
                ]
            ])->hint('Кратко опишите суть работы') ?>

            <?= $form->field($model, 'description', [
                'template' => "{label}\n{input}\n<span>{hint}</span>",
                'options' => [
                    'class' => 'field-container'
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'rows' => '7',
                    'placeholder' => 'Введите свой текст'
                ]
            ])->textarea()
                ->hint('Укажите все пожелания и детали, чтобы исполнителям было проще сориентироваться') ?>

            <?= $form->field($model, 'category', [
                'template' => "{label}\n{input}\n<span>{hint}</span>",
                'options' => [
                    'class' => 'field-container'
                ],
                'inputOptions' => [
                    'class' => 'multiple-select input multiple-select-big',
                    'size' => '1'
                ]
            ])
                ->dropDownList(Categories::find()->select(['name', 'id'])->column())
                ->hint('Выберите категорию') ?>

            <?= $form->field($model, 'files[]', [
                'template' => "{label}\n<span>{hint}</span><div class='create__file'>
                        <span>Добавить новый файл</span>
                    </div>",
                'options' => [
                    'class' => 'field-container'
                ],
                'inputOptions' => [
                    'class' => 'create__file'
                ]
            ])
                ->hint('Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу') ?>

            <?= $form->field($model, 'city', [
                'template' => "{label}\n{input}\n<span>{hint}</span>",
                'options' => [
                    'class' => 'field-container'
                ],
                'inputOptions' => [
                    'type' => 'search',
                    'class' => 'input-navigation input-middle input',
                    'placeholder' => 'Санкт-Петербург, Калининский район'
                ]
            ])
                ->hint('Укажите адрес исполнения, если задание требует присутствия') ?>

            <div class="create__price-time">
                <?= $form->field($model, 'cost', [
                    'template' => "{label}\n{input}\n<span>{hint}</span>",
                    'options' => [
                        'class' => 'field-container create__price-time--wrapper'
                    ],
                    'inputOptions' => [
                        'class' => 'input textarea input-money',
                        'placeholder' => '1000'
                    ]
                ])
                    ->hint('Не заполняйте для оценки исполнителем') ?>

                <?= $form->field($model, 'deadline', [
                    'template' => "{label}\n{input}\n<span>{hint}</span>",
                    'options' => [
                        'class' => 'field-container create__price-time--wrapper'
                    ],
                    'inputOptions' => [
                        'class' => 'input-middle input input-date',
                        'placeholder' => 'ГГГГ-ММ-ДД',
                        'type' => 'text'
                    ]
                ])
                    ->hint('Укажите крайний срок исполнения') ?>
            </div>
            <?php ActiveForm::end(); ?>

            <div class="create__warnings">
                <div class="warning-item warning-item--advice">
                    <h2>Правила хорошего описания</h2>
                    <h3>Подробности</h3>
                    <p>Друзья, не используйте случайный<br>
                        контент – ни наш, ни чей-либо еще. Заполняйте свои
                        макеты, вайрфреймы, мокапы и прототипы реальным
                        содержимым.</p>
                    <h3>Файлы</h3>
                    <p>Если загружаете фотографии объекта, то убедитесь,
                        что всё в фокусе, а фото показывает объект со всех
                        ракурсов.</p>
                </div>
                <?php if($model->errors): ?>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <h3>Категория</h3>
                    <p>Это поле должно быть выбрано.<br>
                        Задание должно принадлежать одной из категорий</p>
                    <?= $form->errorSummary($model) ?>
                </div>
                <?php endif; ?>

            </div>

        </div>

        <?= Html::button('Опубликовать', [
            'form' => 'task-form',
            'class' => 'button',
            'type' => 'submit'
        ]) ?>

    </section>
</div>

<form action="/">

</form>