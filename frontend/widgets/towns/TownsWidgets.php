<?php

namespace frontend\widgets\towns;

use frontend\models\Cities;
use yii\base\Widget;

class TownsWidgets extends Widget
{
    public $city_id;

    public function run()
    {
        $items = Cities::find()->select(['name', 'id'])->indexBy('id')->column();
        return $this->render('towns', [
            'items' => $items
        ]);
    }


}