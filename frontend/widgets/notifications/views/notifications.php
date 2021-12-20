<?php

/**
 * @var Notifications $notifications
 * @var Notifications $notification
 * @var float|int $score
 */

use app\models\Notifications;
use yii\helpers\Url;

?>

<div class="header__lightbulb" style="
<?php if (!empty($notifications) || Yii::$app->session->hasFlash('auth')): ?>
        background-image: url('/img/lightbulb-white.png')
<?php endif; ?>
        "></div>
<div class="lightbulb__pop-up">
    <h3>Новые события</h3>
    <?php if (!empty($notifications)): ?>

        <?php foreach ($notifications as $notification): ?>
            <p class="lightbulb__new-task lightbulb__new-task<?= $notification->icon; ?>">
                <?= $notification->title; ?>
                <a href="<?= Url::to('/task/' . $notification->task_id) ?>" class="link-regular">
                    «<?= $notification->description; ?>»</a>
            </p>
        <?php endforeach; ?>
        <a href="#" class="lightbulb__new-task is-read link-regular" style="display: block; margin-bottom: 10px">
            <b>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-open" viewBox="0 0 16 16">
                <path d="M8.47 1.318a1 1 0 0 0-.94 0l-6 3.2A1 1 0 0 0 1 5.4v.817l5.75 3.45L8 8.917l1.25.75L15 6.217V5.4a1 1 0 0 0-.53-.882l-6-3.2ZM15 7.383l-4.778 2.867L15 13.117V7.383Zm-.035 6.88L8 10.082l-6.965 4.18A1 1 0 0 0 2 15h12a1 1 0 0 0 .965-.738ZM1 13.116l4.778-2.867L1 7.383v5.734ZM7.059.435a2 2 0 0 1 1.882 0l6 3.2A2 2 0 0 1 16 5.4V14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5.4a2 2 0 0 1 1.059-1.765l6-3.2Z"/>
            </svg>
            Прочитано</b>
        </a>
    <?php elseif (Yii::$app->session->hasFlash('auth')): ?>
        <p class="lightbulb__new-task lightbulb__new-task--executor">
            <?= Yii::$app->session->getFlash('auth') ?>
        </p>
    <?php else: ?>
        <p class="lightbulb__new-task no-notice">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-slash" viewBox="0 0 16 16">
                <path d="M5.164 14H15c-.299-.199-.557-.553-.78-1-.9-1.8-1.22-5.12-1.22-6 0-.264-.02-.523-.06-.776l-.938.938c.02.708.157 2.154.457 3.58.161.767.377 1.566.663 2.258H6.164l-1 1zm5.581-9.91a3.986 3.986 0 0 0-1.948-1.01L8 2.917l-.797.161A4.002 4.002 0 0 0 4 7c0 .628-.134 2.197-.459 3.742-.05.238-.105.479-.166.718l-1.653 1.653c.02-.037.04-.074.059-.113C2.679 11.2 3 7.88 3 7c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0c.942.19 1.788.645 2.457 1.284l-.707.707zM10 15a2 2 0 1 1-4 0h4zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75L.625 15.625z"/>
            </svg>
            Нет новых уведомлений
        </p>
    <?php endif; ?>
</div>