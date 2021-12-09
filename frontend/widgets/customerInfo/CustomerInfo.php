<?php

namespace frontend\widgets\customerInfo;

use frontend\models\Tasks;
use frontend\models\Users;
use yii\base\Widget;

/**
 * Виджет отображения информации о пользователе
 */
class CustomerInfo extends Widget
{
    public int $userId;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('index', [
            'count' => $this->getTasksCount(),
            'date' => $this->getElapsedTime()
        ]);
    }

    /**
     * @return int
     */
    private function getTasksCount(): int
    {
        return (int)Tasks::find()->where(['user_id' => $this->userId])->count();
    }

    /**
     * @return string
     */
    private function getElapsedTime(): string
    {
        $userDtAdd = Users::findOne($this->userId)->dt_add;

        return \Yii::$app->formatter->format($userDtAdd, 'relativeTime');
    }
}