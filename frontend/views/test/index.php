<?php

use app\models\Auth;
use frontend\models\Files;
use frontend\models\Users;
use frontend\widgets\ageFormatter\AgeFormatter;
use yii\helpers\Html;

$redirect = 'http://taskforce/test';
$client_id = '8026389';
$client_secret = 'okBY7RXypgqK3ATNtMG6';
$fields = 'uid,first_name,last_name,city,bdate,photo_max_orig,email';
$code = Yii::$app->request->get('code');


if (!$code) {
    print 'Error code';
} else {
    $tokenRequest = "https://oauth.vk.com/access_token?client_id={$client_id}&client_secret={$client_secret}&redirect_uri={$redirect}&code={$code}&scope=friends,email";
    $token = json_decode(file_get_contents($tokenRequest), true);
    if (!$token) {
        print 'Error token';
    } else {
        $dataRequest = 'https://api.vk.com/method/users.get?user_id=' . $token['user_id'] . "&access_token=" . $token['access_token'] . "&fields=" . $fields . "&v=5.131";
        $data = json_decode(file_get_contents($dataRequest), true);
        if (!$data) {
            print 'Error data';
        } else {
            $data = $data['response'][0];

                if (!Users::find()->where(['email' => $token['email']])->one()) {
                    $file = new Files();
                    $file->name = $data['first_name'] . '_pic';
                    $file->path = $data['photo_max_orig'];
                    $file->save();

                    $user = new Users();
                    $user->name = $data['first_name'];
                    $user->email = $token['email'];
                    $user->city_id = 1;
                    $user->avatar_file_id = $file->id;
                    $user->password = Yii::$app->security->generateRandomString(8);
                    if ($user->save()) {
                        Yii::$app->user->login($user);
                        $auth = new Auth();
                        $auth->user_id = Yii::$app->user->getId();
                        $auth->source = (string)$token['expires_in'];
                        $auth->source_id = (string)$token['user_id'];
                        if ($auth->save()) {
                            print 'Пользователь добавлен';
                            print '<br><a href="/">Войти на сайт</a>';
                        }

                    } else {
                        print 'Error auth';
                    }
                }
            }
        }
}

?>

<hr>
<div style="width: 400px; margin: 0 auto">
<?= Html::a('', "https://oauth.vk.com/authorize?client_id={$client_id}&display=page&redirect_uri={$redirect}&scope=friends,email&response_type=code", ['class' => 'auth-icon vkontakte']) ?>
<br><br><br>
<?php if (!empty($data)): ?>

    <h2>ФИО: <?= $data['first_name'] . ', ' . $data['last_name']  ?> <?= AgeFormatter::widget(['birthday' => $data['bdate']])?></h2>
    <h3><?= $token['email'] ?? ''?></h3>
    <img src="<?= $data['photo_max_orig']?>">
<?php endif; ?>
<br><br><br>
</div>

<div style="display: none">
<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['test/auth'],
    'popupMode' => false,
]) ?>
</div>

