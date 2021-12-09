<?php

namespace frontend\widgets\bookmark;

use app\models\Bookmarks;
use frontend\models\Users;
use Yii;
use yii\base\Widget;

/**
 * Виджет для отображения/добавления пользователя в избранное
 */
class Bookmark extends Widget
{
    public Users $user;

    public function run()
    {
        if ($this->user->id != Yii::$app->user->id) {
            return $this->render('index', [
                'user' => $this->user,
                'marker' => $this->getMarker()
            ]);
        }
        return '';
    }

    /**
     * @return string|void
     */
    private function getMarker()
    {
        if ($this->user->bookmarks) {
            return '--current';
        }

        return '';
    }
}