<?php

use frontend\models\Users;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'on beforeAction' => function(){
            if(!Yii::$app->user->isGuest){
                Users::updateAll(['activity'=>time()],['id'=>Yii::$app->user->id]);
            }
        },
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Europe/Moscow'
            ],
        'request' => [
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser'
                ],
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'test' => 'test/index',
                '/' => 'site/index',
                'users' => 'users/index',
                'tasks' => 'tasks/index',
                'create' => 'tasks/create',
                'sign-up' => 'sign-up/index',
                'logout' => 'site/logout',
                'user/<id:\d+>' => 'users/view',
                'task/<id:\d+>' => 'tasks/view',
                'refuse/<id:\d+>' => 'tasks/refuse',
                'accept/<id:\d+>' => 'tasks/accept',
                'cancel/<id:\d+>' => 'tasks/cancel',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api',
                    'pluralize' => false
                ]
            ],
        ],

    ],
    'params' => $params,
];

