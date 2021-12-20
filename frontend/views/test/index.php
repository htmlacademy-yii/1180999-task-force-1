<?php

use app\models\Auth;
use frontend\models\Cities;
use frontend\models\Files;
use frontend\models\Users;
use frontend\widgets\ageFormatter\AgeFormatter;
use yii\helpers\Html;


$searchCity = Cities::find()->where(['like', 'name', 'Москва'])->one();
print $searchCity->id;
