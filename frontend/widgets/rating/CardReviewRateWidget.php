<?php

namespace frontend\widgets\rating;

use yii\base\Widget;

class CardReviewRateWidget extends Widget
{
    public $score;

    private const SCORE_STYLE = [
        1 => 'one-rate',
        2 => 'two-rate',
        3 => 'three-rate',
        4 => 'four-rate',
        5 => 'five-rate',
    ];
    /**
     * @return string
     */
    public function run()
    {
        return $this->render('cardView', [
            'score' => $this->score,
            'style' => $this->getStyle()
        ]);
    }

    /**
     * @return string|null
     */
    private function getStyle(): ?string
    {
        for ($i = 1; $i <=5; $i++){
            switch ($this->score) {
                case $i: return self::SCORE_STYLE[$i];
            }
        }
        return null;
    }
}