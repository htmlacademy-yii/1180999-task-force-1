<?php

namespace frontend\models\forms;

use frontend\models\Tasks;


class TaskCreate extends Tasks
{
    public $name;
    public $description;
    public $category;
    public $imageFiles;
    public $city;
    public $cost;
    public $deadline;
    public $path;

    /**
     * Названия полей формы
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'imageFiles' => 'Файлы',
            'city' => 'Локация',
            'cost' => 'Бюджет',
            'deadline' => 'Сроки исполнения'
        ];
    }

    /**
     * Правила полей формы
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'description', 'category', 'imageFiles', 'city', 'cost', 'deadline'],
                'safe'],
            [['name', 'description', 'category', 'deadline'],
                'required',
                'message' => 'Обязательное поле'],
            [['imageFiles'],
                'file',
                'maxFiles' => 10
            ],
            [['cost'], 'isNumericOnly'],
            [['deadline'], 'dateFormat']
        ];
    }

    /**
     * Загрузка файлов на сервер
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $file->saveAs('@webroot/uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        }
        return false;
    }

    /**
     * Валидация поля на целое и положительное
     * @param $attribute
     */
    public function isNumericOnly($attribute)
    {
        if (!preg_match('#^[0-9]+$#', $this->$attribute)) {
            $this->addError($attribute, 'Содержимое поля "бюджет" должно быть целым числом больше нуля');
        }
    }

    /**
     * Валидация поля даты. Формат должен быть в виде: ГГГГ-ММ-ДД
     * @param $attribute
     */
    public function dateFormat($attribute)
    {
        if (!preg_match('#^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$#', $this->$attribute)) {
            $this->addError($attribute, 'Содержимое поля «срок исполнения» должно быть датой в формате ГГГГ-ММ-ДД');
        }
    }
}