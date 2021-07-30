<?php
/* @var $this yii\web\View */

/**
 * @var $categories object список категорий задач
 * @var $tasks object объект данных задач
 * @var $modelForm object данные из формы
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

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

            <?= $this->render('_form', [
                'modelForm' => $modelForm,
                'categories' => $categories
            ]) ?>

        </div>
    </section>
</div>
