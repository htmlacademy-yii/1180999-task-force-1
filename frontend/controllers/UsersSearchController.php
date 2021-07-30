<?php

namespace frontend\controllers;

use frontend\models\forms\UserFilterForm;
use frontend\models\UsersSearch;
use Yii;
use yii\web\Controller;

class UsersSearchController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]
        );
    }

}
