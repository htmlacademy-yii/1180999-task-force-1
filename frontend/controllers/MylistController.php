<?php

namespace frontend\controllers;

use frontend\models\Tasks;
use frontend\models\Users;
use taskforce\Task;
use yii\data\ActiveDataProvider;

class MylistController extends SecuredController
{
    /**
     * @return string
     */
    public function actionIndex($status): string
    {
        $user = Users::findOne(\Yii::$app->user->getId());
        $tasks = [];
        switch ($status) {
            case Task::STATUS_NEW_EN:
                $tasks = Tasks::find()->where(['user_id' => $user->id])->andFilterWhere(['status' => Task::STATUS_NEW])
                    ->orderBy(['dt_add' => SORT_DESC])->all();
                break;
            case Task::STATUS_IN_WORK_EN:
                $tasks = Tasks::find()->where(['user_id' => $user->id])->andFilterWhere(['status' => Task::STATUS_IN_WORK])
                    ->orderBy(['dt_add' => SORT_DESC])->all();
                break;
            case Task::STATUS_CANCEL_EN:
                $tasks = Tasks::find()->where(['user_id' => $user->id])->andFilterWhere(['status' => Task::STATUS_CANCEL])
                    ->orderBy(['dt_add' => SORT_DESC])->all();
                break;
            case Task::STATUS_SUCCESS_EN:
            case Task::STATUS_FAIL_EN:
                $tasks = Tasks::find()->where(['user_id' => $user->id])->andFilterWhere(['status' => Task::STATUS_SUCCESS])->
                    orFilterWhere(['status' => Task::STATUS_FAIL])->orderBy(['dt_add' => SORT_DESC])->all();
                break;
            case Task::STATUS_HIDDEN_EN:
                $tasks = Tasks::find()->where(['user_id' => $user->id])->andFilterWhere(['status' => Task::STATUS_HIDDEN])
                    ->orderBy(['dt_add' => SORT_DESC])->all();
            break;
            default:
                $tasks = Tasks::find()->where(['user_id' => $user->id])->orderBy(['dt_add' => SORT_DESC])->all();

        }

        return $this->render('index', compact(
            'user', 'tasks', 'status'
        ));
    }
}