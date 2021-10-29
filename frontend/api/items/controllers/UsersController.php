<?php

namespace frontend\api\items\controllers;

use frontend\models\Users;

class UsersController extends BaseApiController
{
    public $modelClass = Users::class;
}