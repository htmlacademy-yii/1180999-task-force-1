<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\forms\UserFilterForm;
use frontend\models\UsersSearch;
use yii\web\Controller;
use frontend\models\Users;
use Yii;

class UsersController extends Controller
{
    /**
     * Функция формирует объект с данными исполнителей
     * @return string
     */
    public function actionIndex(): string
    {
        $modelForm = new UserFilterForm();
        $categories = Categories::find()->all();

        if ($modelForm->load(Yii::$app->request->post())) {
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

}