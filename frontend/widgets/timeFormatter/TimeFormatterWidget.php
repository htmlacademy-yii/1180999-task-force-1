<?php

namespace frontend\widgets\timeFormatter;

use phpDocumentor\Reflection\Types\Null_;
use yii\jui\Widget;
use yii\web\NotFoundHttpException;

/**
 * Виджет для преобразовывает дату в человеко-понятный формат
 * имеет на выбор два типа: для пользователей и задач
 */
class TimeFormatterWidget extends Widget
{
    public ?string $time;
    public string $format;

    const USER_FORMAT = 'userTime';
    const TASK_FORMAT = 'taskTime';

    /**
     * @return string|void
     */
    public function run()
    {
        switch ($this->format) {
            case self::USER_FORMAT:
                return $this->render('lastActiveTime', [
                'time' => $this->time
            ]);
            break;
            case self::TASK_FORMAT:
                return $this->render('timeAdd', [
                    'time' => $this->time
                ]);
        }
    }
}