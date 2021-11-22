<?php

namespace frontend\models\forms;

use yii\base\Model;

class AccountForm extends Model
{
    public $name;
    public $email;
    public $city;
    public $birthday;
    public $aboutMe;
    public $category;
    public $avatar;
    public $password;
    public $passwordRepeat;
    public $images;
    public $phone;
    public $skype;
    public $otherContact;
    public $notification_new_message;
    public $notification_task_action;
    public $notification_new_review;
    public $hide_profile;
    public $show_contacts;

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Адрес',
            'avatar' => 'Сменить аватар',
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

        ];
    }

}