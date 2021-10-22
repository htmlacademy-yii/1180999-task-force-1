<?php

namespace frontend\api\items\controllers;

use frontend\models\Tasks;

class TasksController extends BaseApiController
{
    public $modelClass = Tasks::class;
}