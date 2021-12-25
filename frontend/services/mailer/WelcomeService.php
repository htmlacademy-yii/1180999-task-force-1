<?php

namespace frontend\services\mailer;

use frontend\models\forms\SingUpForm;
use Yii;

class WelcomeService
{
    /**
     * @param SingUpForm $data
     */
    public function send(SingUpForm $data)
    {
        $subject = 'Вы успешно зарегистрировались на сайте Taskforce';
        $body = require_once 'patterns/registration.php';

        Yii::$app->mailer->compose()
            ->setFrom('info@taskforce.com')
            ->setTo($data->email)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }
}