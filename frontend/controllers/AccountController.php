<?php

namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\forms\AccountForm;
use frontend\models\Users;
use frontend\models\UsersCategories;
use frontend\models\UsersFiles;
use frontend\services\AccountUpdateService;
use Yii;
use yii\data\ActiveDataProvider;

class AccountController extends SecuredController
{

    /**
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionIndex()
    {
        $user = Users::findOne(Yii::$app->user->getId());
        $userForm = new AccountForm();
        $userFiles = UsersFiles::find()
            ->where(['user_id' => $user->id]);
        $categories = Categories::find()
            ->select(['name', 'id'])
            ->indexBy('id')->column();
        $userCategories = UsersCategories::find()->select('category_id')
            ->where(['user_id' => $user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $userFiles,
            'pagination' => [
                'pageSize' => 6
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $userForm->category_ids = $userCategories->indexBy('category_id')->column();

        if ($userCategories->count() < 1) {
            $user->is_executor = 0;
        } else {
            $user->is_executor = 1;
        }
        $user->save();

        if (Yii::$app->request->isPost) {
                $service = new AccountUpdateService($user, $userCategories, $userForm);
                if ($service->execute() === 1) {
                    Yii::$app->session->setFlash('changeMessage', 'Профиль успешно обновлен');
                } else {
                    Yii::$app->session->setFlash('errorMessage', 'Ошибка обновления');
                }
            return $this->redirect(['account/index']);

        }

        return $this->render('index', [
            'user' => $user,
            'userForm' => $userForm,
            'dataProvider' => $dataProvider,
            'categories' => $categories
        ]);
    }
}