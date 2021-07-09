<?php
/* @var $this yii\web\View */

/**
 * @var $tasks object объект данных задач
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
print "<pre>" . print_r($_GET) . "</pre>";
?>
<div class="main-container page-container">
    <section class="new-task">
        <div class="new-task__wrapper">
            <h1>Новые задания</h1>
            <?php foreach ($tasks as $task): ?>
                <div class="new-task__card">
                    <div class="new-task__title">
                        <a href="view.html" class="link-regular"><h2><?= $task->name ?></h2></a>
                        <a class="new-task__type link-regular" href="#"><p><?= $task->category->name ?></p></a>
                    </div>
                    <div class="new-task__icon new-task__icon--translation"></div>
                    <p class="new-task_description">
                        <?= $task->description ?>
                    </p>
                    <b class="new-task__price new-task__price--translation"><?= $task->cost ?><b> ₽</b></b>
                    <p class="new-task__place"><?= $task->city->name ?></p>
                    <span class="new-task__time"><?= $task->dt_add ?></span>
                </div>
            <?php endforeach; ?>
            <div class="new-task__pagination">
                <ul class="new-task__pagination-list">
                    <li class="pagination__item"><a href="#"></a></li>
                    <li class="pagination__item pagination__item--current">
                        <a>1</a></li>
                    <li class="pagination__item"><a href="#">2</a></li>
                    <li class="pagination__item"><a href="#">3</a></li>
                    <li class="pagination__item"><a href="#"></a></li>
                </ul>
            </div>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'search-task__form'],
                'method' => 'get',
                'fieldConfig' => [
                    'labelOptions' => ['class' => 'checkbox__legend'],
                    'options' => ['tag' => false]
                ]
            ]) ?>

            <fieldset class="search-task__categories">
                <legend>Категории</legend>

                <?php foreach ($categories as $category): ?>
                <label class="checkbox__legend">
                    <?= $form->field($model, 'categories', [
                        'template' => "{input}"
                    ])->input('checkbox', [
                        'class' => 'visually-hidden checkbox__input',
                        'value' => $category->id
                    ]) ?>
                    <span><?= $category->name ?></span>
                </label>
                <?php endforeach; ?>

                <fieldset class="search-task__categories">
                    <legend>Дополнительно</legend>
                    <label class="checkbox__legend">
                        <?= $form->field($model, 'noExecutor', [
                            'template' => "{input}"
                        ])->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'value' => $model->attributeLabels()['noExecutor']
                        ]) ?>
                        <span><?= $model->attributeLabels()['noExecutor'] ?></span>
                    </label>
                    <label class="checkbox__legend">
                        <?= $form->field($model, 'isDistance', [
                            'template' => "{input}"
                        ])->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'value' => $model->attributeLabels()['isDistance']
                        ]) ?>
                        <span><?= $model->attributeLabels()['isDistance'] ?></span>
                    </label>

                </fieldset>
                <div class="field-container">
                    <label class="search-task__name" for="8">Период</label>
                    <select class="multiple-select input" id="8" size="1" name="time[]">
                        <option value="day">За день</option>
                        <option selected value="week">За неделю</option>
                        <option value="month">За месяц</option>
                    </select>
                </div>
                <div class="field-container">
                    <label class="search-task__name" for="9">Поиск по названию</label>
                    <input class="input-middle input" id="9" type="search" name="q" placeholder="">
                </div>
                <?= Html::submitButton('Поиск', [
                    'type' => 'submit',
                    'class' => 'button'
                ]) ?>

                <?php ActiveForm::end(); ?>
        </div>
    </section>
</div>
