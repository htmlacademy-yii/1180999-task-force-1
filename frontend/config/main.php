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
    'modules' => [
        'api' => [
            'class' => 'frontend\api\items\Module'
        ]
    ],
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
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                'test' => 'test/run',
                '/' => 'site/index',
                'users' => 'users/index',
                'tasks' => 'tasks/index',
                'create' => 'tasks/create',
                'sign-up' => 'sign-up/index',
                'logout' => 'site/logout',
                'user/<id:\d+>' => 'users/view',
                'bookmark/<favorite_id:\d+>' => 'users/add-bookmark',
                'task/<id:\d+>' => 'tasks/view',
                'refuse/<id:\d+>' => 'tasks/refuse',
                'accept/<id:\d+>' => 'tasks/accept',
                'cancel/<id:\d+>' => 'tasks/cancel',
                'refusal/<id:\d+>' => 'tasks/refusal',
                'mylist/<status:\w+>' => 'mylist/index',
                'account' => 'account/index',
                'delete/<id:\d+>' => 'files/delete',
                'avatar-delete/<id:\d+>' => 'files/avatar-delete',
                'events' => 'events/index',
                ['class' => 'yii\rest\UrlRule',
                    'controller' => ['api/messages'],
                    'pluralize' => false
                ],
            ],
        ],

        'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'vkontakte' => [
                'class' => 'yii\authclient\clients\VKontakte',
                'clientId' => '8026389',
                'clientSecret' => 'okBY7RXypgqK3ATNtMG6',
            ]
        ],
    ]

    ],
    'params' => $params,

];

