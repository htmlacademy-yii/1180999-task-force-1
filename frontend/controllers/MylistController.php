<?php

namespace frontend\controllers;

use frontend\models\Tasks;
use frontend\models\Users;
use taskforce\Task;
use Yii;
use yii\data\ActiveDataProvider;

class MylistController extends SecuredController
{
    /**
     * @param null $status
     * @return string
     */
    public function actionIndex($status = null): string
    {
        $user = Users::findOne(Yii::$app->user->identity->getId());
        $query = Tasks::find()->where(['user_id' => $user->id])->orWhere(['executor_id' => $user->id]);

        switch ($status) {
            case Task::STATUS_NEW_EN:
                $query->andWhere(['status' => Task::STATUS_NEW]);
                break;
            case Task::STATUS_IN_WORK_EN:
                $query->andWhere(['status' => Task::STATUS_IN_WORK]);
                break;
            case Task::STATUS_CANCEL_EN:
            case Task::STATUS_FAIL_EN:
                $query->andWhere(['status' => [Task::STATUS_FAIL, Task::STATUS_CANCEL]]);
                break;
            case Task::STATUS_SUCCESS_EN:
                $query->andWhere(['status' => Task::STATUS_SUCCESS]);
                break;
            case Task::STATUS_HIDDEN_EN:
                $query->andWhere(['status' => Task::STATUS_HIDDEN]);
        }

        $tasks = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'dt_add' => SORT_DESC
                ]
            ],
        ]);

        return $this->render('index', compact(
            'user', 'tasks', 'status'
        ));
    }
}