<?php

namespace frontend\services\mailer;

use frontend\models\Tasks;
use Yii;

class MailerService
{
    const CHAT_MESSAGE = 0;
    const RESPONSE_MESSAGE = 1;
    const REFUSAL_MESSAGE = 2;
    const START_MESSAGE = 3;
    const END_MESSAGE = 4;
    const REVIEW_MESSAGE = 5;

    public function send($type, Tasks $task, string $email)
    {
        $result = '';

        switch ($type) {
            case self::CHAT_MESSAGE:
                $result = $this->messagePattern();
                break;
            case self::RESPONSE_MESSAGE:
                $result = $this->responsePattern();
                break;
            case self::REFUSAL_MESSAGE:
                $result = $this->refusalPattern();
                break;
            case self::START_MESSAGE:
                $result = $this->startPattern();
                break;
            case self::END_MESSAGE:
                $result = $this->endPattern();
                break;
            case self::REVIEW_MESSAGE:
                $result = $this->reviewPattern();
        }

        $subject = $result['subject'];
        $body = require_once $result['body'];

        Yii::$app->mailer->compose()
            ->setFrom('info@taskforce.com')
            ->setTo($email)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }

    /**
     * @return string[]
     */
    private function messagePattern(): array
    {
        return [
            'subject' => 'Новое сообщение на сайте Taskforce',
            'body' => 'patterns/message.php'
        ];
    }

    /**
     * @return string[]
     */
    private function responsePattern(): array
    {
        return [
            'subject' => 'Новый отклик на сайте Taskforce',
            'body' => 'patterns/response.php'
        ];
    }

    /**
     * @return string[]
     */
    private function refusalPattern(): array
    {
        return [
            'subject' => 'Отказ от исполнения на сайте Taskforce',
            'body' => 'patterns/refusal.php'
        ];
    }

    /**
     * @return string[]
     */
    private function startPattern(): array
    {
        return [
            'subject' => 'Ваш отклик принят на сайте Taskforce',
            'body' => 'patterns/start.php'
        ];
    }

    /**
     * @return string[]
     */
    private function endPattern(): array
    {
        return [
            'subject' => 'Задание завершено на сайте Taskforce',
            'body' => 'patterns/end.php'
        ];
    }

    /**
     * @return string[]
     */
    private function reviewPattern(): array
    {
        return [
            'subject' => 'У вас новый отзыв на сайте Taskforce',
            'body' => 'patterns/review.php'
        ];
    }
}