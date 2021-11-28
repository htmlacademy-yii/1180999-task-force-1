<?php

namespace frontend\controllers;

use frontend\models\forms\UserFilterForm;
use frontend\models\Reviews;
use frontend\models\UsersCategories;
use frontend\models\UsersFiles;
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

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = Users::findOne($id);
        $dataProvider = new ActiveDataProvider([
            'query' => UsersFiles::find()->where(['user_id' => $user->id]),
            'pagination' => [
                'pageSize' => 3
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не найден");
        }

        return $this->render('view', compact(
            'user', 'dataProvider'
        ));
    }

}