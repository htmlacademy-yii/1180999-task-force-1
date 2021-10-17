<?php
/**
 * @var SingUpForm $model
 */

use frontend\models\forms\SingUpForm;

?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'options' => [
        'data' => ['pjax' => true]
    ]
]) ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'email') ?>
<?php \yii\widgets\Pjax::begin() ?>
    <?= $form->field($model, 'city') ?>
<?php \yii\widgets\Pjax::end() ?>
    <?= $form->field($model, 'password') ?>
<?= \yii\helpers\Html::submitButton('send') ?>
<?php \yii\widgets\ActiveForm::end()?>

