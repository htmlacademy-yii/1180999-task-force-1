<?php
/**
 * @var $items
 * @var $dataProvider
 * @var $modelForm
 * @var $categories
 */

use yii\widgets\ListView;

?>

<div class="main-container page-container">

    <section class="new-task">
        <?php if ($dataProvider->getTotalCount() > 0): ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_task',

            'itemOptions' => [
                'tag' => false,
            ],

            'options' => [
                'tag' => false,
            ],

            'layout' => "<div class='new-task__wrapper'>
                                <h1>Новые задания</h1>
                                    {items}
                             </div>
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
        ])
        ?>

    <?php else: ?>

    <?= \yii\bootstrap\Alert::widget([
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
                'modelForm' => $modelForm,
                'categories' => $categories,
            ]) ?>

        </div>
    </section>

</div>


