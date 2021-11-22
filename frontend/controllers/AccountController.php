<?php

namespace frontend\controllers;

use frontend\models\forms\AccountForm;
use frontend\models\Users;
use yii\helpers\Url;

class AccountController extends SecuredController
{
    public function actionIndex()
    {
        $user = Users::findOne(\Yii::$app->user->getId());
        $userForm = new AccountForm();

        return $this->render('index', compact(
            'user',
            'userForm'
        ));
    }
}