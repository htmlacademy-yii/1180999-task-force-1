<?php

namespace frontend\models\forms;

use frontend\helpers\GetMaxFileSize;
use frontend\models\Tasks;


class TaskCreateForm extends Tasks
{
    public $name;
    public $description;
    public $category;
    public $files;
    public $city;
    public $cost;
    public $deadline;
    public $path;

    /**
     * Названия полей формы
     * @return array
     */
    public function attributeLabels(): array
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

    /**
     * Правила полей формы
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'description', 'category', 'files', 'city', 'cost', 'deadline'],
                'safe'],
            [['name', 'description', 'category'],
                'required',
                'message' => 'Обязательное поле'],
            [['files'],
                'file',
                'maxFiles' => 6,
                'maxSize' => GetMaxFileSize::getSizeLimits(),

            ],
            [['category'], 'integer'],
            [['name'], 'forName'],
            [['description'], 'forDescription'],
            [['cost'], 'isNumericOnly'],
            ['deadline', 'forDate']
        ];
    }

    /**
     * Валидация поля "Мне нужно"
     */
    public function forName()
    {
        if (strlen($this->name) < 10) {
            $this->addError('name', 'Содержимое поля должно быть не менее 10 символов');
        }
    }

    /**
     * Валидация поля "Описание"
     */
    public function forDescription()
    {
        if (strlen($this->description) < 30) {
            $this->addError('description', 'Содержимое поля должно быть не менее 30 символов');
        }
    }

    /**
     * Валидация поля на целое и положительное
     * @param $attribute
     */
    public function isNumericOnly($attribute)
    {
        if (!preg_match('#^[0-9]+$#', $this->$attribute)) {
            $this->addError($attribute, 'Содержимое поля должно быть целым числом больше нуля');
        }
    }

    /**
     * Валидация поля "Описание"
     */
    public function forDate()
    {
        if ($this->deadline < date('Y-m-d')) {
            $this->addError('deadline', 'Указана дата раньше текущей');
        }
    }
}