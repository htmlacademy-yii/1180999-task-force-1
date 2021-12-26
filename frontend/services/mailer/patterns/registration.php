<?php

/**
 * @var $data SingUpForm
 */

use frontend\models\forms\SingUpForm;

return'<h3>Регистрация прошла успешно</h3>
<p>
<h4>Ваши данные:</h4>
<b>Имя: </b>' . $data->name . '<br>
<b>Город: </b>' . $data->city . '<br>
<b>Логин: </b>' . $data->email . '<br>
<b>Пароль: </b>' . $data->password . '
<p>
<h4>Работа для всех.<br>
    Найди исполнителя на любую задачу.</h4>
<ul>
    <li>Достоверные отзывы</li>
    <li>Оплата по факту работы</li>
    <li>Экономия времени и денег</li>
    <li>Выгодные цены</li>
</ul>
<a href="http://taskforce/users">Список доступных специалистов</a>
<h4>Вы готовы приступить?</h4>
<a href="http://taskforce/create">Создать задачу</a>
<p>
<h4>Информация для исполнителей</h4>
<ul>
    <li>Большой выбор заданий</li>
    <li>Работайте где удобно</li>
    <li>Свободный график</li>
    <li>Удалённая работа</li>
    <li>Гарантия оплаты</li>
</ul>
<a href="http://taskforce/tasks">Список доступных заданий</a>
' . require_once 'layouts/footer.php';
