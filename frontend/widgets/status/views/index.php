<?php

/**
 * @var $status string
 */

use taskforce\Task;

switch ($status) {
    case Task::STATUS_IN_WORK:
        print 'work-status';
        break;
    case Task::STATUS_CANCEL:
    case Task::STATUS_FAIL:
        print 'fail-status';
        break;
    case Task::STATUS_SUCCESS:
        print 'done-status';
        break;
    case Task::STATUS_HIDDEN:
        print 'hidden-status';
        break;
    default:
        print 'new-status';
}

