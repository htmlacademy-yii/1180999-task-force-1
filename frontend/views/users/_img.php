<?php

/**
 * @var $model UsersFiles
 */


use frontend\models\UsersFiles;
use yii\bootstrap\Modal;
use yii\helpers\Html;

?>


<?php Modal::begin([
    'header' => $model->file->name,
    'toggleButton' => ['label' => Html::a(
        Html::img($model->file->path, [
            'style' => [
                'width' => '85px',
                'min-height' => '86px'
            ],
            'alt' => $model->file->name

        ]),
    ), 'class' => 'btn-img']
]);

print Html::img($model->file->path, [
    'style' => [
        'width' => '100%',
        'margin-bottom' => '15px'
    ],
]);

Modal::end()

?>

