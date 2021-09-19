<?php


namespace frontend\models\forms;

use yii\base\Model;

/**
 * Модель формы регистрации
 * Class SingUpForm
 * @package frontend\models\forms
 */
class SingUpForm extends Model
{
    public $email;
    public $name;
    public $city;
    public $password;

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            'unique' => [
                'email', 'unique',
                'targetClass' => 'frontend\models\Users',
                'message' => 'Пользователь с таким e-mail уже существует'
            ],

            'safe' => [
                ['email', 'name', 'city', 'password'],
                'safe'
            ],

            'required' => [
                ['email', 'name', 'city', 'password'],
                'required', 'message' => 'Обязательное поле'
            ],

            'email' => [
                'email', 'email',
                'message' => 'Введите валидный адрес электронной почты'
            ],

            'name' => [
                'name', 'string',
                'message' => 'Введите ваше имя и фамилию'
            ],

            'password' => [
                'password', 'string',
                'min' => 8,
                'tooShort' => 'Длина пароля от 8 символов'
            ]
        ];
    }
}