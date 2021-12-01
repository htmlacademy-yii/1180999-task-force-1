<?php

namespace frontend\widgets\executorInfo;

use frontend\models\Reviews;
use frontend\models\Tasks;
use frontend\models\Users;
use Yii;

class ExecutorInfo extends \yii\base\Widget
{
    public int $id;

    /**
     * @return string
     */
    public function run(): string
    {
        if (Yii::$app->controller->action->id === 'index') {
            return $this->render('users', [
                'executorId' => $this->id,
                'info' => $this->getInfo()
            ]);
        }
            return $this->render('index', ['info' => $this->getInfo()]);
    }

    /**
     *
     */
    private function getInfo()
    {
        $user = Users::findOne($this->id);
        return [
            'tasksCount' => (int)Tasks::find()->where(['executor_id' => $user->id])->count(),
            'reviewsCount' => (int)Reviews::find()->where(['executor_id' => $user->id])->count(),
            'avatar' => $user->avatarFile->path
        ];
    }
}