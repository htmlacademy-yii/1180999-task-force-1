<?php

namespace frontend\widgets\headerMenu;

use yii\base\Widget;

class HeaderMenuWidget extends Widget
{

    public function run()
    {
        return $this->render('headerMenu');
    }
}