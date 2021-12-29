<?php
/**
 * @var $user Users пользователь
 * @var $specializations UsersCategories специализации
 * @var $dataProvider \yii\data\ActiveDataProvider фотографии для портфолио
 */

use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\UsersCategories;
use frontend\widgets\ageFormatter\AgeFormatter;
use frontend\widgets\bookmark\Bookmark;
use frontend\widgets\executorInfo\ExecutorInfo;
use frontend\widgets\rating\CardReviewRateWidget;
use frontend\widgets\rating\RatingWidget;
use frontend\widgets\showContacts\ShowContacts;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>

    <div class="main-container page-container">
        <section class="content-view">
            <?php if (Yii::$app->session->hasFlash('bookmark-add')): ?>
                <?= Alert::widget([
                    'options' => [
                        'class' => 'alert-success',
                        'style' => [
                            'margin' => '20px 20px'
                        ]
                    ],
                    'body' => Yii::$app->session->getFlash('bookmark-add')
                ]) ?>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('bookmark-delete')): ?>
                <?= Alert::widget([
                    'options' => [
                        'class' => 'alert-danger',
                        'style' => [
                            'margin' => '20px 20px'
                        ]
                    ],
                    'body' => Yii::$app->session->getFlash('bookmark-delete')
                ]) ?>
            <?php endif; ?>

            <div class="user__card-wrapper">
                <div class="user__card">
                    <img src="<?= $user->avatarFile->path ?? '/img/no-photos.png' ?>" width="120" height="120"
                         alt="Аватар пользователя">
                    <div class="content-view__headline">
                        <h1><?= $user->name ?></h1>
                        <p>
                            <?= $user->city->name ?>
                            <?= $user->birthday ? ', ' . AgeFormatter::widget(['birthday' => $user->birthday]) : '' ?>
                        </p>
                        <div class="profile-mini__name five-stars__rate">
                            <?= RatingWidget::widget(['rating' => $user->calcRatingScore()]) ?>
                        </div>
                        <?= ExecutorInfo::widget(['id' => $user->id]) ?>
                    </div>

                    <?= Bookmark::widget(['user' => $user]) ?>

                </div>
                <div class="content-view__description">
                    <p><?= $user->about_me ?></p>
                </div>
                <div class="user__card-general-information">
                    <div class="user__card-info">
                        <h3 class="content-view__h3">Специализации</h3>
                        <div class="link-specialization">
                            <?php foreach ($user->categories as $spec): ?>
                                <?= Html::a($spec->category->name,
                                    Url::to(['tasks/index', 'TaskFilterForm' => [
                                        'category_ids' => $spec->category_id
                                    ]]), [
                                        'class' => 'link-regular'
                                    ]
                                ) ?>

                            <?php endforeach; ?>
                        </div>

                        <?= ShowContacts::widget(['user' => $user]) ?>

                    </div>
                    <div class="user__card-photo">
                        <h3 class="content-view__h3">Фото работ</h3>

                        <?php Pjax::begin() ?>
                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}",
                            'itemView' => '_img',
                            'options' => [
                                'style' => [
                                    'width' => '100%',
                                    'display' => 'flex',
                                    'flex-direction' => 'inherit',
                                    'justify-content' => 'flex-start',
                                    'align-items' => 'center',
                                    'margin-bottom' => '20px'
                                ]
                            ]
                        ]) ?>
                        <?=
                        LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                            'options' => [
                                'class' => 'pagination',
                                'style' => [
                                    'display' => 'flex',
                                    'justify-content' => 'end'
                                ]
                            ]
                        ]);
                        ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
            <div class="content-view__feedback">
                <h2>Отзывы<span> (<?= count($user->reviewsByExecuted) ?>)</span></h2>
                <div class="content-view__feedback-wrapper reviews-wrapper">

                    <?php foreach ($user->getReviewsByExecuted()->all() as $review): ?>
                        <div class="feedback-card__reviews">
                            <p class="link-task link">Задание
                                <?= Html::a($review->task->name,
                                    Url::to(['tasks/view', 'id' => $review->id]),
                                    ['class' => 'link-regular']
                                ) ?>
                            </p>
                            <div class="card__review">
                                <?= Html::a(Html::img($review->user->avatarFile->path ?? "/img/no-photos.png",
                                    ['height' => 54]
                                ), Url::to(['users/view', 'id' => $review->user_id])
                                ) ?>
                                <div class="feedback-card__reviews-content">
                                    <p class="link-name link">
                                        <?= Html::a($review->user->name,
                                            Url::to(['users/view', 'id' => $review->user_id]),
                                            ['class' => 'link-regular']
                                        ) ?>
                                    </p>
                                    <p class="review-text">
                                        <?= $review->text ?? '' ?>
                                    </p>
                                </div>
                                <?= CardReviewRateWidget::widget(['score' => $review->score]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </section>
        <section class="connect-desk">
        </section>
    </div>