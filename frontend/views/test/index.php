<?php


use yii\helpers\ArrayHelper;

$model = new \frontend\models\forms\TaskCreateForm();

    $cities = \frontend\models\Cities::find()->select(['id', 'name'])->limit(10)->all();

$arrayData = ArrayHelper::toArray($cities, [
    'frontend\models\Cities' => [
        "name"
    ],
]);

$items = ArrayHelper::getColumn($arrayData, 'name');

var_dump($items);

    $form = \yii\widgets\ActiveForm::begin();

print    $form->field($model, 'location')->widget(\yii\jui\AutoComplete::className(), [
    'clientOptions' => [
        'source' => $items,
    ],
]);

    \yii\widgets\ActiveForm::end();