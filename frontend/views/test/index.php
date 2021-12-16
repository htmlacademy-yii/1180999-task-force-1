<?php

use app\models\Auth;
use frontend\models\Files;
use frontend\models\Users;
use frontend\widgets\ageFormatter\AgeFormatter;
use yii\helpers\Html;


$ss = 'https://sun1-54.userapi.com/s/v1/ig2/mUlSwtIUIuIjRv_Nuo0FW63aojCqoQvz69LoA7DEISM707XJPdSL5CYmWtOKgDEA4YncISNGv4lhToKZxHdmw5g1.jpg?size=200x200&quality=96&crop=240,492,1182,1182&ava=1';

$new = new Files();
$new->name = uniqid() . '_ava';
$new->path = $ss;
$new->save();

print $new->id;

