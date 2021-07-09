<?php
namespace frontend\models;

use yii\base\Model;

class TaskFilterForm extends Model
{
    public $categories;
    public $noExecutor;
    public $isDistance;
    public $time;
    public $search;

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'noExecutor' => 'Без исполнителя',
            'isDistance' => 'Удаленная работа',
            'time' => 'Период',
            'search' => 'Поиск'
        ];
    }
}

