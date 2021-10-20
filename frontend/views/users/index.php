<?php

/**
 * @var $dataProvider ActiveDataProvider;
 * @var $items Users;
 * @var $filterForm UserFilterForm;
 */

use frontend\models\forms\UserFilterForm;
use yii\bootstrap\Alert;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use frontend\models\Users;


?>
<div class="main-container page-container">
    <section class="user__search">
<?php if ($dataProvider->getTotalCount() > 0): ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_user',
        'layout' => "<div class='content-view__feedback-card user__search-wrapper'>
                        {items}</div>
                      <div class='new-task__pagination'>
                             {pager}\n
                      </div>",
        'pager' => [

            'options' => [
                'class' => 'new-task__pagination-list',
            ],
            'prevPageLabel' => '',
            'nextPageLabel' => '',
            'prevPageCssClass' => 'pagination__item',
            'nextPageCssClass' => 'pagination__item',
            'pageCssClass' => 'pagination__item',
            'activePageCssClass' => 'pagination__item--current',
        ],
    ]) ?>

<?php else: ?>

    <?= Alert::widget([
        'body' => 'Ничего не найдено',
        'options' => [
            'class' => 'alert alert-danger',
            'style' => 'margin-bottom: 0'
        ]
    ]);
    ?>
<?php endif; ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?= $this->render('_filterForm', [
                    'filterForm' => $filterForm
            ]) ?>
        </div>
</div>
