<?php

/**
 * @var $model object loginForm data
 */

?>


<div class="landing-container">
    <div class="landing-top">
        <h1>Работа для всех.<br>
            Найди исполнителя на любую задачу.</h1>
        <p>Сломался кран на кухне? Надо отправить документы? Нет времени самому гулять с собакой?
            У нас вы быстро найдёте исполнителя для любой жизненной ситуации?<br>
            Быстро, безопасно и с гарантией. Просто, как раз, два, три. </p>
        <button class="button">Создать аккаунт</button>
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
            <div class="landing-task">
                <div class="landing-task-top task-courier"></div>
                <div class="landing-task-description">
                    <h3><a href="#" class="link-regular">Подключить принтер</a></h3>
                    <p>Необходимо подключить старый матричный принтер, у него еще LPT порт…</p>
                </div>
                <div class="landing-task-info">
                    <div class="task-info-left">
                        <p><a href="#" class="link-regular">Курьерские услуги</a></p>
                        <p>25 минут назад</p>
                    </div>
                    <span>700 <b>₽</b></span>
                </div>
            </div>
            <div class="landing-task">
                <div class="landing-task-top task-cargo"></div>
                <div class="landing-task-description">
                    <h3><a href="#" class="link-regular">Офисный переезд</a></h3>
                    <p>Требуется перевезти офисную мебель
                        и технику из расчета 5 сотрудников</p>
                </div>
                <div class="landing-task-info">
                    <div class="task-info-left">
                        <p><a href="#" class="link-regular">Грузоперевозки</a></p>
                        <p>25 минут назад</p>
                    </div>
                    <span>1 800 <b>₽</b></span>
                </div>
            </div>
            <div class="landing-task">
                <div class="landing-task-top task-neo"></div>
                <div class="landing-task-description">
                    <h3><a href="#" class="link-regular">Убраться в квартире</a></h3>
                    <p>Моей хате давно нужна генеральная уборка.
                        В наличии есть только пылесос. </p>
                </div>
                <div class="landing-task-info">
                    <div class="task-info-left">
                        <p><a href="#" class="link-regular">Уборка</a></p>
                        <p>1 час назад</p>
                    </div>
                    <span>2000 <b>₽</b></span>
                </div>
            </div>
            <div class="landing-task">
                <div class="landing-task-top task-flat"></div>
                <div class="landing-task-description">
                    <h3><a href="#" class="link-regular">Празднование ДР</a></h3>
                    <p>Моему другу нужно
                        устроить день рождения,
                        который он никогда не
                        забудет</p>
                </div>
                <div class="landing-task-info">
                    <div class="task-info-left">
                        <p><a href="#" class="link-regular">Мероприятия</a></p>
                        <p>1 час назад</p>
                    </div>
                    <span>2000 <b>₽</b></span>
                </div>
            </div>
        </div>
        <div class="landing-bottom-container">
            <button type="button" class="button red-button">смотреть все задания</button>
        </div>
    </div>
</div>
<?= $this->render('_form', [
    'model' => $model
])
?>