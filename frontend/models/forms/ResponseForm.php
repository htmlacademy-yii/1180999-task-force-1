<?php

namespace frontend\models\forms;

use yii\base\Model;

class ResponseForm extends Model
{
    public $price;
    public $description;

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'description' => 'Комментарий'
        ];
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            'safe' => [
                ['price', 'description'], 'safe'
            ],
            'required' => [
                ['price'], 'required', 'message' => 'обязательное поле'
            ],
            'isNumeric' => [
                ['price'], 'isNumericOnly'
            ]
        ];
    }

    /**
     * Валидация поля на целое и положительное
     * @param $attribute
     */
    public function isNumericOnly($attribute)
    {
        if (!preg_match('#^[0-9]+$#', $this->$attribute)) {
            $this->addError($attribute, 'Цена должна быть целым числом больше нуля');
        }
    }

}