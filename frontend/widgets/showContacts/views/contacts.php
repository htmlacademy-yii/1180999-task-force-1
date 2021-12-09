<?php

/**
 * @var Users $user
 * @var int $count
 */

use frontend\models\Users;

?>


<?php if ($count > 0 && $user->show_contacts === 1
    || $user->id === Yii::$app->user->id): ?>
    <h3 class="content-view__h3">Контакты</h3>
    <div class="user__card-link">
        <a class="user__card-link--tel link-regular" href="tel:7<?= $user->phone ?>">
            <?= $user->phone ?>
        </a>
        <a class="user__card-link--email link-regular" href="mailto:<?= $user->email ?>"><?= $user->email ?></a>
        <a class="user__card-link--skype link-regular" href="#"><?= $user->skype ?></a>
        <a class="user__card-link--other link-regular" href="#"><?= $user->skype ?></a>
    </div>
<?php endif; ?>