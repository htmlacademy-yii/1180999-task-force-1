<?php
namespace frontend\models\forms;

use yii\base\Model;

class TaskFilterForm extends Model
{
    public $category_ids;
    public $noResponses;
    public $remote;
    public $interval;
    public $search;

    const INTERVAL_DEFAULT = 0;
    const INTERVAL_DAY = 1;
    const INTERVAL_WEEK = 2;
    const INTERVAL_MONTH = 3;

    /**
     * @return string[] названия полей формы
     */
    public function attributeLabels(): array
    {
        return [
            'category_ids' => 'Категория',
            'noResponses' => 'Без откликов',
            'remote' => 'Удаленная работа',
            'interval' => 'Период',
            'search' => 'Поиск по названию'
        ];
    }

    /**
     * @return array[] поля формы
     */
    public function rules(): array
    {
        return [
            [['category_ids', 'noResponses', 'remote', 'interval', 'search'],'safe']
        ];
    }

    /**
     * @return string[] список интервалов
     */
    public static function getIntervalName(): array
    {
        return [
            self::INTERVAL_DEFAULT => 'Не выбран',
            self::INTERVAL_DAY => 'За день',
            self::INTERVAL_WEEK => 'За неделю',
            self::INTERVAL_MONTH => 'За месяц'
        ];
    }
}

