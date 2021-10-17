<?php

namespace frontend\services\api;

use GuzzleHttp\Client;
use Yii;
use yii\helpers\Json;

class GeoCoderApi
{
    public function getData($address): array
    {
        if (!$address) {
            $address = 'Москва';
        }

        $api = new Client();
        $uri = 'https://geocode-maps.yandex.ru/1.x';

        $resource = $api->request('GET', $uri, [
            'query' => [
                'geocode' => $address,
                'apikey' => Yii::$app->params['yandexApiKey'],
                'format' => 'json'
            ],
        ]);

        $content = $resource->getBody()->getContents();

        $responseData = Json::decode($content);

        $pointsKey = $responseData
        ['response']
        ['GeoObjectCollection']
        ['featureMember'][0]
        ['GeoObject']
        ['Point']
        ['pos'];

        $cityKey = $responseData
        ['response']
        ['GeoObjectCollection']
        ['featureMember'][0]
        ['GeoObject']
        ['description'];

        $streetKey = $responseData
        ['response']
        ['GeoObjectCollection']
        ['featureMember'][0]
        ['GeoObject']
        ['name'];

        $points = array_reverse(explode(' ', $pointsKey));

        return [
            'city' => $cityKey,
            'street' => $streetKey,
            'points' => [
                'latitude' => $points[0],
                'longitude' =>  $points[1]
            ]
        ];

    }

}