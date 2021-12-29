<?php

/**
 * @var Users $user
 * @var int $count
 */

use frontend\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<?php if ($count > 0 && $user->show_contacts === 1
    || $user->id === Yii::$app->user->id): ?>
    <h3 class="content-view__h3">Контакты</h3>
    <div class="user__card-link">
        <?= Html::a($user->phone ? '+7' . $user->phone : '',
            Url::to('tel:7' . $user->phone),
            ['class' => 'user__card-link--tel link-regular']
        ) ?>
        <?= Html::a($user->email,
            Url::to('mailto:' . $user->email),
            ['class' => 'user__card-link--email link-regular']
        ) ?>
        <?= Html::a($user->skype,
            '#',
            ['class' => 'user__card-link--skype link-regular']
        ) ?>
        <?= Html::a($user->other_contacts,
            '#',
            ['class' => 'user__card-link--other link-regular']
        ) ?>
    </div>
<?php endif; ?>