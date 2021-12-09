<?php

/**
 * @var array $items
 */

use frontend\models\forms\TownSelectForm;
use yii\widgets\ActiveForm;

$model = new TownSelectForm();

?>

<?php
$form = ActiveForm::begin();

$params = [
    'prompt' => 'Выберите город...',
    'options' => [
        Yii::$app->user->identity->city_id => ['Selected' => true]
    ]
];
echo $form->field($model, 'town', [
        'options' => [
                'class' => 'header__town'
        ],
        'inputOptions' => [
                'class' => 'multiple-select input town-select'
        ]
])->dropDownList($items,$params)->label(false);

ActiveForm::end();
?>