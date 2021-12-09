<?php

/**
 * @var $model UsersFiles
 */

use frontend\models\UsersFiles;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<?php Modal::begin([
    'header' => $model->file->name,
    'toggleButton' => ['label' => Html::a(
        Html::img($model->file->path, [
            'style' => [
                'width' => '120px',
                'min-height' => '120px'
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

print Html::a('Удалить файл',
        Url::to(['files/delete', 'id' => $model->id]),
        ['class' => 'btn btn-danger']
);

Modal::end() ?>

