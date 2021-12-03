<?php

namespace frontend\widgets\ageFormatter;

use DateTime;
use Exception;
use yii\base\Widget;

/**
 * Виджет для отображения человеко-понятного формата возраста
 * Пример использования:
 *  "AgeFormatter::widget(['birthday' => '1990-01-01])"
 */
class AgeFormatter extends Widget
{
    public string $birthday;

    private const UNITS_AGE = [
        'one' => 'год',
        'two' => 'года',
        'many' => 'лет'
    ];

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return $this->getAge();
    }

    /**
     * Функция подсчета и вывода возраста в правильном формате
     * @return string
     * @throws Exception
     */
    private function getAge(): string
    {
        $birthday = new DateTime($this->birthday);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthday)->y;
        
        if (($age % 100 >= 11) && ($age % 100 <= 19)) {
            return self::UNITS_AGE['many'];
        } else {
            switch ($age % 10) {
                case 1:
                    return $age . ' ' . self::UNITS_AGE['one'];
                case 2:
                case 3:
                case 4:
                    return $age . ' ' . self::UNITS_AGE['two'];
                default:
                    return $age . ' ' . self::UNITS_AGE['many'];
            }
        }
    }
}