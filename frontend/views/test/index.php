<?php


use frontend\models\Categories;
use frontend\models\Users;
use frontend\models\Cities;
use Faker\Factory;

$categories = Categories::find()->all();
$users = Users::find()->all();
$cities = Cities::find()->all();
$faker = Factory::create();

?>

<div class="container mb-5">
    <label for="city">Список городов</label>
    <select name="" id="city" class="form-select">
        <option value="" selected disabled>Выбрать из списка</option>
        <?php foreach ($cities as $city): ?>
            <option value=""><?= $city->name ?></option>
        <?php endforeach; ?>
    </select>

    <label for="faker">Фейковые города</label>
    <select name="" id="faker" class="form-select">
        <option value="" selected disabled>Выбрать из списка</option>
        <?php foreach (range(1, 100) as $x): ?>
            <option value=""><?= $faker->state ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="container">
    <h4>Категории</h4>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Код</th>
            <th scope="col">Наименование</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category->id ?></td>
                <td><?= $category->code ?></td>
                <td><?= $category->name ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="container">
    <h4>Пользователи</h4>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Имя</th>
            <th scope="col">Емайл</th>
            <th scope="col">Контакты</th>
            <th scope="col">Информация</th>
            <th scope="col">Город</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->contacts ?></td>
                <td><?= $user->about_me ?></td>
                <td><?= $user->city->name ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>