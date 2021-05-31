<?php

/**
 * Это тестовый скрипт
 */

require_once __DIR__ . '/vendor/autoload.php';

try {
    $categories = new \taskforce\import_csv\ImportCategories();
    $categories->import();

    $cities = new \taskforce\import_csv\ImportCities();
    $cities->import();

    $users = new \taskforce\import_csv\ImportUsers();
    $users->import();

} catch (Exception $e) {
    print $e->getMessage();
}
