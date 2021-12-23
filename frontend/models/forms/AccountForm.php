<?php

namespace frontend\models\forms;

use frontend\helpers\GetMaxFileSize;
use yii\base\Model;

class AccountForm extends Model
{
    public $name;
    public $email;
    public $city;
    public $birthday;
    public $aboutMe;
    public $category_ids = [];
    public $avatar;
    public $password;
    public $passwordRepeat;
    public $images;
    public $phone;
    public $skype;
    public $otherContacts;
    public $notification_new_message;
    public $notification_task_action;
    public $notification_new_review;
    public $show_contacts;
    public $hide_profile;

    private $_user;

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Адрес',
            'avatar' => 'Сменить аватар',
            'images' => 'Выбрать фотографии',
            'birthday' => 'День рождения',
            'aboutMe' => 'Информация о себе',
            'password' => 'Новый пароль',
            'passwordRepeat' => 'Повтор пароля',
            'phone' => 'Телефон',
            'skype' => 'Skype',
            'otherContacts' => 'Другой мессенджер'
        ];
    }

    public function rules()
    {
        return [
            [[
                'category_ids',
                'name',
                'email',
                'city',
                'avatar',
                'birthday',
                'aboutMe',
                'password',
                'passwordRepeat',
                'phone',
                'skype',
                'otherContacts',
                'passwordRepeat',
                'password',
                'notification_new_message',
                'notification_task_action',
                'notification_new_review',
                'show_contacts',
                'hide_profile'
            ], 'safe'],

            [['images'],
                'file',
                'skipOnEmpty' => true,
                'maxFiles' => 6,
                'extensions' => 'png, jpg',
                'maxSize' => GetMaxFileSize::getSizeLimits()

            ],

            [['avatar'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg',
                'maxFiles' => 1
            ],

            ['password', 'string',
                'min' => 8,
                'tooShort' => 'Длина пароля от 8 символов'
            ],

            ['passwordRepeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают'
            ],

        ];
    }
}