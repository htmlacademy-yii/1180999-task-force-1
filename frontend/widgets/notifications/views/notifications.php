<?php

/**
 * @var Notifications $notifications
 */

use app\models\Notifications;
use yii\helpers\Url;

?>

<div class="header__lightbulb" style="
<?php if (!empty($notifications)): ?>
        background-image: url(/img/lightbulb-white.png)
<?php endif; ?>
        "></div>
<div class="lightbulb__pop-up">
    <h3>Новые события</h3>
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notification): ?>
            <p class="lightbulb__new-task lightbulb__new-task<?= $notification->icon; ?>">
                <?= $notification->description; ?>
                <a href="<?= Url::to('/task/' . $notification->task_id) ?>" class="link-regular">
                    «<?= $notification->title; ?>»</a>
            </p>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="lightbulb__new-task no-notice">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-chat-right-text" viewBox="0 0 16 16">
                <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
            </svg>
            нет новых уведомлений
        </p>
    <?php endif; ?>
</div>