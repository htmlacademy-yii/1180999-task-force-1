<?php

/**
 * @var $info array Количество задач и отзывов
 */

?>

<b class="done-task">Выполнил
    <?= Yii::$app->i18n->format(
        '{n, plural, 
                =1{# заказ} 
                =2{# заказа} 
                =3{# заказа} 
                =4{# заказа} 
                other{# заказов}}',
        ['n' => $info['tasksCount']],
        'ru_RU'
    );
    ?>
</b>
<b class="done-review">Получил
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
</b>

