<?php

namespace frontend\api\modules\v1\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class BaseApiController extends ActiveController
{

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @return bool
     */
    public function checkAccess($action, $model = null, $params = []): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML
                ]
            ]
        ];
    }

}