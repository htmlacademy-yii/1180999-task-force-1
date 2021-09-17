<?php

namespace frontend\models\forms;

use frontend\models\Tasks;


class TaskCreate extends Tasks
{
    public $name;
    public $description;
    public $category;
    public $files;
    public $city;
    public $cost;
    public $deadline;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'files' => 'Файлы',
            'city' => 'Локация',
            'cost' => 'Бюджет',
            'deadline' => 'Сроки исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category', 'files', 'city', 'cost', 'deadline'],
                'safe'],
            [['name', 'description', 'category', 'files', 'deadline'],
                'required',
                'message' => 'Обязательное поле'],
            [['cost'], 'isNumbersOnly', 'message' => ''],
            [['deadline'],
                'date',
                'format' => 'Y-m-d',
                'message' => 'Содержимое поля «срок исполнения» должно быть датой в формате ГГГГ-ММ-ДД'
                ]
        ];
    }

    /**
     * Проверка на целочисленность
     * @param $attribute
     */
    public function isNumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]$/', $this->$attribute)) {
            $this->addError($attribute, 'Поле "Бюджет" должно быть целым числом больше нуля');
        }
    }
}