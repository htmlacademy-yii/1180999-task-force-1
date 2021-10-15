<?php

namespace frontend\controllers;

use frontend\services\api\GeoCoderApi;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        $service = new GeoCoderApi();
        $geoData = $service->getData('');

        var_dump($geoData);
    }
}
