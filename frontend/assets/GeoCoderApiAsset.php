<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Yandex GeoCoder API asset bundle.
 */
class GeoCoderApiAsset extends AssetBundle
{
    public $js = [
        "https://api-maps.yandex.ru/2.1/?apikey=ac1c1abe-bfd4-4c51-ae85-f0cc07493924&lang=ru_RU",
    ];
    public $jsOptions = ['position' => View::POS_HEAD];
}