<?php

/**
 * @var $model object loginForm data
 * @var $tasks object 4 последних созданных задач
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>


    <div class="landing-container">
        <div class="landing-top">
            <h1>Работа для всех.<br>
                Найди исполнителя на любую задачу.</h1>
            <p>Сломался кран на кухне? Надо отправить документы? Нет времени самому гулять с собакой?
                У нас вы быстро найдёте исполнителя для любой жизненной ситуации?<br>
                Быстро, безопасно и с гарантией. Просто, как раз, два, три. </p>
            <?= Html::a('Создать аккаунт', Url::to(['sign-up/index']), [
                'class' => 'button',
                'data' => ['method' => 'post']
            ]) ?>
        </div>
        <div class="landing-center">
            <div class="landing-instruction">
                <div class="landing-instruction-step">
                    <div class="instruction-circle circle-request"></div>
                    <div class="instruction-description">
                        <h3>Публикация заявки</h3>
                        <p>Создайте новую заявку.</p>
                        <p>Опишите в ней все детали
                            и стоимость работы.</p>
                    </div>
                </div>
                <div class="landing-instruction-step">
                    <div class="instruction-circle  circle-choice"></div>
                    <div class="instruction-description">
                        <h3>Выбор исполнителя</h3>
                        <p>Получайте отклики от мастеров.</p>
                        <p>Выберите подходящего<br>
                            вам исполнителя.</p>
                    </div>
                </div>
                <div class="landing-instruction-step">
                    <div class="instruction-circle  circle-discussion"></div>
                    <div class="instruction-description">
                        <h3>Обсуждение деталей</h3>
                        <p>Обсудите все детали работы<br>
                            в нашем внутреннем чате.</p>
                    </div>
                </div>
                <div class="landing-instruction-step">
                    <div class="instruction-circle circle-payment"></div>
                    <div class="instruction-description">
                        <h3>Оплата&nbsp;работы</h3>
                        <p>По завершении работы оплатите
                            услугу и закройте задание</p>
                    </div>
                </div>
            </div>
            <div class="landing-notice">
                <div class="landing-notice-card card-executor">
                    <h3>Исполнителям</h3>
                    <ul class="notice-card-list">
                        <li>
                            Большой выбор заданий
                        </li>
                        <li>
                            Работайте где удобно
                        </li>
                        <li>
                            Свободный график
                        </li>
                        <li>
                            Удалённая работа
                        </li>
                        <li>
                            Гарантия оплаты
                        </li>
                    </ul>
                </div>
                <div class="landing-notice-card card-customer">
                    <h3>Заказчикам</h3>
                    <ul class="notice-card-list">
                        <li>
                            Исполнители на любую задачу
                        </li>
                        <li>
                            Достоверные отзывы
                        </li>
                        <li>
                            Оплата по факту работы
                        </li>
                        <li>
                            Экономия времени и денег
                        </li>
                        <li>
                            Выгодные цены
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="landing-bottom">
            <div class="landing-bottom-container">
                <h2>Последние задания на сайте</h2>
                <?php foreach ($tasks as $task): ?>
                    <div class="landing-task">
                        <div class="landing-task-top task-<?= $task->category->code ?>"></div>
                        <div class="landing-task-description">
                            <h3>
                                <?= Html::a(
                                    mb_strimwidth($task->name, 0, 20, "..."),
                                    Url::to("/task/$task->id"),
                                    [
                                        'class' => 'link-regular'
                                    ]
                                ) ?>
                            </h3>
                            <p><?= mb_strimwidth($task->description, 0, 90, "..."); ?></p>
                        </div>
                        <div class="landing-task-info">
                            <div class="task-info-left">
                                <p>
                                    <?= Html::a($task->category->name,
                                        Url::to([
                                            'tasks/index',
                                            'TaskFilterForm' => [
                                                'category_ids' => $task->category_id
                                                ]
                                            ]),
                                        ['class' => 'link-regular']
                                        )
                                    ?>
                                </p>
                                <p><?= Yii::$app->formatter->format($task->dt_add, 'relativeTime') ?></p>
                            </div>
                            <span><?= $task->cost ? $task->cost . '<b>₽</b>' : ''?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="landing-bottom-container">
                <?= Html::a('смотреть все задания', ['tasks/index'], ['class' => 'button red-button']) ?>
            </div>
        </div>
    </div>
<?= $this->render('_form', [
    'model' => $model
])
?>