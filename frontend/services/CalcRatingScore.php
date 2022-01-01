<?php

namespace frontend\services;

use frontend\models\Users;

/**
 * Сервис подсчета общего рейтинга исполнителя
 */
class CalcRatingScore
{
    /**
     * @param $id int Идентификатор пользователя
     * @return float|int Общий рейтинг
     */
    public static function run(int $id)
    {
        $executor = Users::findOne($id);
        if (!$executor) {
            return 0;
        }
        $sum = [];
        foreach ($executor->getReviewsByExecuted()->all() as $item) {
            if ($item->score) {
                $sum[] = $item->score;
            }
        }
        if (count($sum) === 0) {
            return 0;
        }

        return array_sum($sum) / count($sum);
    }

}