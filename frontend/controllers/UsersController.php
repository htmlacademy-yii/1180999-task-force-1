<?php

namespace frontend\controllers;

use frontend\models\forms\UserFilterForm;
use frontend\models\Reviews;
use frontend\models\UsersSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use frontend\models\Users;
use yii\web\NotFoundHttpException;

class UsersController extends SecuredController
{
    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->goHome();
                },
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Users::find()->where(['is_executor' => 1]);
        $filterForm = new UserFilterForm();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        $users = $provider->getModels();

        if ($filterForm->load(\Yii::$app->request->get())) {
            $usersSearch = new UsersSearch();
            $provider = $usersSearch->search($filterForm);
            $users = $provider->getModels();
        }

        return $this->render('index', [
            'dataProvider' => $provider,
            'filterForm' => $filterForm
        ]);
    }

    public function actionView($id)
    {
        $user = Users::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не найден");
        }

        $reviews = Reviews::find()->where(['executor_id' => $user->id])->all();


        return $this->render('view', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }

}