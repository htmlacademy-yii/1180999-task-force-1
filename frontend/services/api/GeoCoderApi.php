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

        $resource = $api->request('GET', Yii::$app->params['geocoder']['uri'], [
            'query' => [
                'geocode' => $address,
                'apikey' => Yii::$app->params['geocoder']['token'],
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
                'longitude' => $points[1],
                'latitude' => $points[0],
            ],
            'yMapsPoints' => "$points[0],$points[1]"
        ];
    }
}