<?php

namespace frontend\models\forms;

use frontend\models\Tasks;


class TaskCreateForm extends Tasks
{
    public $name;
    public $description;
    public $category;
    public $files;
    public $location;
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
            'files' => 'Файлы',
            'location' => 'Локация',
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
            [['name', 'description', 'category', 'files', 'location', 'cost', 'deadline'],
                'safe'],
            [['name', 'description', 'category'],
                'required',
                'message' => 'Обязательное поле'],
            [['files'],
                'file',
                'maxFiles' => 10
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


    /**
     * Загрузка файлов на сервер
     * @return bool|array
     */
    public function uploadFiles()
    {
        $taskFiles = [];

        $url = 'uploads/' . date("Y-m-d") .'_'. date("H-m-s") . '/';
        if (!is_dir($url)) {
            mkdir($url, 0777);
        }

        if ($this->validate()) {
            foreach ($this->files as $file) {
                $file->saveAs($url . $file->baseName . '.' . $file->extension);
                $taskFiles[] = ["$file->baseName.$file->extension" => $url . $file->baseName . '.' . $file->extension];
            }
            return $taskFiles;
        }
        return false;
    }
}