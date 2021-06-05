<?php

/**
 * Это тестовый скрипт
 */

use taskforce\importer\ImportCategories;
use taskforce\importer\ImportCities;
use taskforce\importer\ImportUsers;
use taskforce\importer\ImportTasks;
use taskforce\importer\ImportReviews;

require_once __DIR__ . '/vendor/autoload.php';

//Импортируем данные

 try {
     $categories = new ImportCategories('data/categories.csv', ['name', 'icon']);
     $categories->importData();

     $cities = new ImportCities('data/cities.csv', ['name', 'lat', 'long']);
     $cities->importData();

     $reviews = new ImportReviews('data/replies.csv', ['dt_add', 'rate', 'description']);
     $reviews->importData();

     $tasks = new ImportTasks('data/replies.csv', [
         'dt_add', 'category_id', 'description', 'expire', 'name', 'address', 'budget', 'lat', 'long']);
     $tasks->importData();

     $users = new ImportUsers('data/users.csv', [
         'email', 'name', 'password', 'dt_add', 'address', 'bd', 'about', 'phone', 'skype']);
     $users->importData();

 } catch (Exception $e) {
     print $e->getMessage();
 }
