<?php

namespace frontend\models\forms;

use yii\base\Model;

class CompletionForm extends Model
{
    public $completeness;
    public $description;
    public $rating;

    const COMPLETE_YES = 0;
    const COMPLETE_DIFF = 1;

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'completeness' => 'Задание выполнено?',
            'description' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
     return [
         [['completeness', 'description', 'rating'], 'safe'],
         [['completeness'], 'required'],
         [['rating'], 'in','range' => range(1, 5)]
     ];
    }

    /**
     * @return string[]
     */
    public static function getCompleteFlag(): array
    {
        return [
            self::COMPLETE_YES => 'да',
            self::COMPLETE_DIFF => 'возникли проблемы'
        ];
    }
}