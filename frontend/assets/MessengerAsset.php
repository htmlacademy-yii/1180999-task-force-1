<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MessengerAsset extends AssetBundle
{
    public $js = [
        'js/messenger.js'
    ];
    public $jsOptions = ['position' => View::POS_END];
}