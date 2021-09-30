<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\forms\UserFilterForm;
use frontend\models\Responses;
use frontend\models\Reviews;
use frontend\models\UsersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use frontend\models\Users;
use Yii;
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
        $modelForm = new UserFilterForm();
        $categories = Categories::find()->all();

        if ($modelForm->load(Yii::$app->request->get())) {
            $userSearch = new UsersSearch();
            $dataProvider = $userSearch->search($modelForm);
            $users = $dataProvider->getModels();
        } else {
            $users = Users::find()->where(['is_executor' => 1])->orderBy('dt_add DESC')->all();
        }

        return $this->render(
            'users', [
                'modelForm' => $modelForm,
                'users' => $users,
                'categories' => $categories
            ]
        );
    }

    public function actionView($id)
    {
        $user = Users::findOne($id);
        $reviews = Reviews::find()->where(['executor_id' => $user->id])->all();

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не найден");
        }

        return $this->render('view', [
            'user' => $user,
            'reviews' => $reviews
        ]);
    }

}