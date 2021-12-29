<?php


namespace frontend\models\forms;

use frontend\models\Cities;
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

    private $_city;

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    public function rules(): array
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
            ],
             'city' => ['city', 'forCity']
        ];
    }

    /**
     * City field validation
     */
    public function forCity()
    {
        $this->_city = Cities::findOne(['name' => $this->city]);

        if (!$this->_city) {
            $this->addError('city', 'Город не найден');
        }
    }

    /**
     * Get city id
     * @return int
     */
    public function getCityId(): int
    {
        return $this->_city->id;
    }
}