<?php
/**
* @var $info array Количество задач и отзывов
* @var $executorId int Идентификатор исполнителя
* @var $avatar string путь к аватарке исполнителя
*/

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= Html::a(
        Html::img($info['avatar'] ?? '/img/no-photos.png', [
        'width' => 65,
        'height' => 65,
        'alt' => 'Аватар исполнителя',
    ]),
    Url::to(['users/view', 'id' => $executorId])
) ?>

<span>
    <?= Yii::$app->i18n->format(
        '{n, plural, 
                =1{# задание} 
                =2{# задания} 
                =3{# задания} 
                =4{# задания} 
                other{# заданий}}',
        ['n' => $info['tasksCount']],
        'ru_RU'
    );
    ?>
</span>
<span>
    <?= Yii::$app->i18n->format(
        '{n, plural, 
                =1{# отзыв} 
                =2{# отзыва} 
                =3{# отзыва} 
                =4{# отзыва} 
                other{# отзывов}}',
        ['n' => $info['reviewsCount']],
        'ru_RU'
    );
    ?>
</span>