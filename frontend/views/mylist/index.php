<?php

/**
 * @var $user Users
 * @var $tasks Tasks
 * @var $task Tasks
 * @var $status string
 */

use frontend\models\Tasks;
use frontend\models\Users;
use frontend\widgets\rating\RatingWidget;
use frontend\widgets\status\StatusWidget;
use taskforce\Task;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="main-container page-container">
    <section class="menu-toggle">
        <ul class="menu-toggle__list">
            <li class="menu-toggle__item menu-toggle__item--completed <?= $status === Task::STATUS_SUCCESS_EN ? 'menu_toggle__item--current' : '' ?>">
                <div class="menu-toggle__svg-wrapper">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="<?= $status === Task::STATUS_SUCCESS_EN ? '#fff' : '#000' ?>" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 10C0 4.47715 4.47715 0 10 0C12.6522 0 15.1957 1.05357 17.0711 2.92893C18.9464 4.8043 20 7.34784 20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10ZM9.73 13.61L14.3 7.61V7.58C14.5179 7.29419 14.5668 6.91382 14.4283 6.58218C14.2897 6.25054 13.9848 6.01801 13.6283 5.97218C13.2718 5.92635 12.9179 6.07419 12.7 6.36L8.92 11.36L7.29 9.28C7.07028 8.99776 6.71668 8.85418 6.36239 8.90334C6.00811 8.9525 5.70696 9.18694 5.57239 9.51834C5.43783 9.84974 5.49028 10.2278 5.71 10.51L8.15 13.62C8.34082 13.8615 8.63222 14.0017 8.94 14C9.2495 13.9993 9.54121 13.8552 9.73 13.61Z"/>
                    </svg>
                </div>
                <?= Html::a('Завершённые', Url::to(['mylist/'.Task::STATUS_SUCCESS_EN])) ?>
            </li>
            <li class="menu-toggle__item menu-toggle__item--new <?= $status === Task::STATUS_NEW_EN ? 'menu_toggle__item--current' : '' ?>">
                <div class="menu-toggle__svg-wrapper">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="<?= $status === Task::STATUS_NEW_EN ? '#fff' : '#000' ?>" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.01" x="24" y="24" width="24" height="24" transform="rotate(180 24 24)"
                              />
                        <path
                                d="M12 6C12.5523 6 13 5.55228 13 5V3C13 2.44772 12.5523 2 12 2C11.4477 2 11 2.44772 11 3V5C11 5.55228 11.4477 6 12 6Z"
                                />
                        <path
                                d="M21 11H19C18.4477 11 18 11.4477 18 12C18 12.5523 18.4477 13 19 13H21C21.5523 13 22 12.5523 22 12C22 11.4477 21.5523 11 21 11Z"
                                />
                        <path
                                d="M6 12C6 11.4477 5.55228 11 5 11H3C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H5C5.55228 13 6 12.5523 6 12Z"
                                />
                        <path
                                d="M6.22 4.99995C5.81407 4.61611 5.17384 4.63402 4.79 5.03995C4.40616 5.44588 4.42407 6.08611 4.83 6.46995L6.27 7.85995C6.46525 8.04848 6.72875 8.14955 7 8.13995C7.27219 8.13891 7.53219 8.02696 7.72 7.82995C8.10772 7.43991 8.10772 6.80999 7.72 6.41995L6.22 4.99995Z"
                                />
                        <path
                                d="M17 8.14C17.2575 8.13898 17.5046 8.03869 17.69 7.86L19.13 6.47C19.4946 6.08908 19.5007 5.49053 19.1441 5.10217C18.7874 4.71382 18.1905 4.66911 17.78 5L16.34 6.42C15.9523 6.81004 15.9523 7.43997 16.34 7.83C16.5131 8.01272 16.7488 8.12342 17 8.14Z"
                                />
                        <path
                                d="M12 18C11.4477 18 11 18.4477 11 19V21C11 21.5523 11.4477 22 12 22C12.5523 22 13 21.5523 13 21V19C13 18.4477 12.5523 18 12 18Z"
                                />
                        <path
                                d="M17.73 16.14C17.3324 15.7561 16.6988 15.7673 16.315 16.165C15.9312 16.5626 15.9424 17.1961 16.34 17.58L17.78 19C17.9654 19.1786 18.2125 19.2789 18.47 19.28C18.7407 19.2815 19.0005 19.1733 19.19 18.98C19.3793 18.7922 19.4858 18.5366 19.4858 18.27C19.4858 18.0033 19.3793 17.7477 19.19 17.56L17.73 16.14Z"
                                />
                        <path
                                d="M6.27 16.14L4.83 17.53C4.64069 17.7178 4.5342 17.9734 4.5342 18.24C4.5342 18.5066 4.64069 18.7622 4.83 18.95C5.0195 19.1433 5.27929 19.2516 5.55 19.25C5.79651 19.2521 6.03512 19.1631 6.22 19L7.66 17.61C8.05765 17.2262 8.06884 16.5926 7.685 16.195C7.30116 15.7974 6.66765 15.7862 6.27 16.17V16.14Z"
                                />
                        <path
                                d="M12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8V8Z"
                                />
                    </svg>
                </div>
                <?= Html::a('Новые', Url::to(['mylist/'.Task::STATUS_NEW_EN])) ?>
            </li>
            <li class="menu-toggle__item menu-toggle__item--active  <?= $status === Task::STATUS_IN_WORK_EN ? 'menu_toggle__item--current' : '' ?>">
                <div class="menu-toggle__svg-wrapper">
                    <svg width="21" height="19" viewBox="0 0 21 19" fill="<?= $status === Task::STATUS_IN_WORK_EN ? '#fff' : '#000' ?>" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M16 4.52L20.6 8.22C20.8463 8.4046 20.9938 8.6923 21 9V13C21 13.5523 20.5523 14 20 14H19.8C20.252 15.2453 19.8336 16.6396 18.7708 17.4304C17.7079 18.2212 16.2521 18.2212 15.1892 17.4304C14.1264 16.6396 13.708 15.2453 14.16 14H7.8C8.25289 15.2595 7.81666 16.6667 6.73074 17.4491C5.64482 18.2315 4.17193 18.2 3.12053 17.3717C2.06912 16.5435 1.69357 15.1189 2.2 13.88C1.45527 13.5552 0.981015 12.8122 0.999999 12V2C0.948749 0.955797 1.74653 0.0644265 2.79 0H14.19C15.2414 0.0538855 16.051 0.948426 16 2V4.52ZM19 12V9.48L16 7.08V12H19ZM6 15C6 15.5523 5.55228 16 5 16C4.44771 16 4 15.5523 4 15C4 14.4477 4.44771 14 5 14C5.55228 14 6 14.4477 6 15ZM17 16C17.5523 16 18 15.5523 18 15C18 14.4477 17.5523 14 17 14C16.4477 14 16 14.4477 16 15C16 15.5523 16.4477 16 17 16Z"
                              fill=""/>
                    </svg>
                </div>
                <?= Html::a('Активные', Url::to(['mylist/'.Task::STATUS_IN_WORK_EN])) ?>
            </li>
            <li class="menu-toggle__item menu-toggle__item--canceled <?= $status === Task::STATUS_CANCEL_EN ? 'menu_toggle__item--current' : '' ?>">
                <div class="menu-toggle__svg-wrapper">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="<?= $status === Task::STATUS_CANCEL_EN ? '#fff' : '#000' ?>" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 10C0 4.47715 4.47715 0 10 0C12.6522 0 15.1957 1.05357 17.0711 2.92893C18.9464 4.8043 20 7.34784 20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10ZM13.0058 12C13.0058 11.7334 12.8993 11.4778 12.71 11.29L11.41 10L12.71 8.71C13.1021 8.31788 13.1021 7.68212 12.71 7.29C12.3179 6.89788 11.6821 6.89788 11.29 7.29L10 8.59L8.71 7.29C8.31788 6.89788 7.68212 6.89788 7.29 7.29C6.89788 7.68212 6.89788 8.31788 7.29 8.71L8.59 10L7.29 11.29C7.10069 11.4778 6.9942 11.7334 6.9942 12C6.9942 12.2666 7.10069 12.5222 7.29 12.71C7.47777 12.8993 7.73336 13.0058 8 13.0058C8.26664 13.0058 8.52223 12.8993 8.71 12.71L10 11.41L11.29 12.71C11.4778 12.8993 11.7334 13.0058 12 13.0058C12.2666 13.0058 12.5222 12.8993 12.71 12.71C12.8993 12.5222 13.0058 12.2666 13.0058 12Z"
                              fill=""/>
                    </svg>
                </div>
                <?= Html::a('Отменённые', Url::to(['mylist/'.Task::STATUS_CANCEL_EN])) ?>

            </li>
            <li class="menu-toggle__item menu-toggle__item--hidden <?= $status === Task::STATUS_HIDDEN_EN ? 'menu_toggle__item--current' : '' ?>">
                <div class="menu-toggle__svg-wrapper">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="<?= $status === Task::STATUS_HIDDEN_EN ? '#fff' : '#000' ?>" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.01" x="24" width="24" height="24" transform="rotate(90 24 0)" fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M18 3H6C4.76379 3.00732 3.65865 3.7722 3.21635 4.92661C2.77405 6.08101 3.08517 7.38852 4 8.22V18C4 19.6569 5.34315 21 7 21H17C18.6569 21 20 19.6569 20 18V8.22C20.9148 7.38852 21.226 6.08101 20.7837 4.92661C20.3414 3.7722 19.2362 3.00732 18 3ZM15 13.13C15 13.6105 14.6105 14 14.13 14H9.87C9.38951 14 9 13.6105 9 13.13V12.87C9 12.3895 9.38951 12 9.87 12H14.13C14.6105 12 15 12.3895 15 12.87V13.13ZM6 7H18C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5H6C5.44772 5 5 5.44772 5 6C5 6.55228 5.44772 7 6 7Z"
                              fill=""/>
                    </svg>
                </div>
                <?= Html::a('Просроченные', Url::to(['mylist/'.Task::STATUS_HIDDEN_EN])) ?>
            </li>
        </ul>
    </section>
    <section class="my-list">
        <div class="my-list__wrapper">
            <h1>Мои задания</h1>
            <?php if ($tasks): ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <?= Html::a('<h2>' . $task->name . '</h2>',
                                Url::to(['tasks/view', 'id' => $task->id]),
                                ['class' => 'link-regular']
                            ) ?>
                            <?= Html::a('<p>' . $task->category->name . '</p>',
                                Url::to('/tasks?TaskFilterForm%5Bcategory_ids%5D=' . $task->category_id),
                                ['class' => 'new-task__type link-regular']
                            ) ?>
                        </div>
                        <div class="task-status <?= StatusWidget::widget(['status' => $task->status]) ?>">
                            <?= $task->status ?></div>
                        <p class="new-task_description">
                            <?= mb_strimwidth($task->description, 0, 90, "..."); ?>
                        </p>
                        <?php if ($task->executor): ?>
                            <div class="feedback-card__top">
                                <a href="#"><img src="<?= $task->executor->avatarFile->path ?? '/img/user-man.jpg' ?>" width="36" height="36"></a>
                                <div class="feedback-card__top--name my-list__bottom">
                                    <p class="link-name">
                                        <?= Html::a($task->executor->name,
                                            Url::to(['users/view', 'id' => $task->executor_id]),
                                            ['class' => 'link-regular']
                                        ) ?>
                                    </p>
                                    <a href="#" class="my-list__bottom-chat"></a>
                                    <?= RatingWidget::widget(['rating' => $task->executor->calcRatingScore()]) ?>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</div>