<?php


namespace frontend\models\forms;

use yii\base\Model;


class UserFilterForm extends Model
{
    public $category_ids;
    public $isFree;
    public $online;
    public $review;
    public $favorite;
    public $nameSearch;

    /**
     * @return string[] названия полей формы
     */
    public function attributeLabels(): array
    {
        return [
            'category_ids' => 'Категории',
            'isFree' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'review' => 'Есть отзывы',
            'favorite' => 'В избранном',
            'nameSearch' => 'Поиск по имени'
        ];
    }

    /**
     * @return array[] поля формы
     */
    public function rules(): array
    {
        return [
            [
                ['category_ids', 'isFree', 'online', 'review', 'favorite', 'nameSearch'], 'safe'
            ]
        ];
    }


}