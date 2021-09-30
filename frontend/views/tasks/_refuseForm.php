<?php

/**
 * @var $task object Данные задачи
 */

use taskforce\Task;use yii\helpers\Html;
use yii\helpers\Url;

?>

<h2>Отказ от задания</h2>
<p>
    Вы собираетесь отказаться от выполнения задания.
    Это действие приведёт к снижению вашего рейтинга.
    Вы уверены?
</p>


<?= Html::a('Отказаться',
    Url::to(['tasks/cancel', 'id' => $task->id]), [
        'class' => 'button__form-modal refusal-button button',
        'type' => 'button'
    ]
); ?>

<button class="button__form-modal button" id="close-modal"
        type="button">Отмена
</button>

<button class="form-modal-close" type="button">Закрыть</button>
