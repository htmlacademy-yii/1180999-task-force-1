<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\forms\UserFilterForm;
use frontend\models\Reviews;
use frontend\models\UsersSearch;
use yii\web\Controller;
use frontend\models\Users;
use Yii;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
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
            $users = Users::find()->all();
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

        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не найден");
        }

        return $this->render('view', [
            'user' => $user
        ]);
    }

}