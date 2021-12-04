<?php

/**
 * @var $user Users
 * @var $categories Categories
 * @var $dataProvider ActiveDataProvider
 * @var $userForm AccountForm
 */

use frontend\models\Categories;
use frontend\models\Cities;
use frontend\models\forms\AccountForm;
use frontend\models\Users;

use yii\bootstrap\Alert;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;

?>
<div class="main-container page-container">
    <section class="account__redaction-wrapper">

        <?php if (Yii::$app->session->hasFlash('changeMessage')): ?>
            <?= Alert::widget([
                'options' => [
                    'class' => 'alert-success',
                    'style' => [
                        'margin' => '20px 0'
                    ]
                ],
                'body' => 'Профиль успешно обновлен'
            ]) ?>
        <?php endif; ?>

        <h1>Редактирование настроек профиля</h1>
        <?php $form = ActiveForm::begin() ?>
        <div class="account__redaction-section">
            <h3 class="div-line">Настройки аккаунта</h3>
            <div class="account__redaction-section-wrapper">

                <?= $form->field($userForm, 'avatar', [
                    'template' =>
                        Html::img($user->avatarFile->path ?? '/img/no-photos.png', [
                            'width' => '135px',
                            'height' => '135px',
                            'margin-right' => '10px'
                        ])
                        . "{input}{label}"
                        . Html::submitButton('Загрузить', [
                                'class' => 'btn',
                                'style' => [
                                    'width' => '107px'
                                ]
                            ]
                        )
                        . Html::a('Удалить',
                                Url::to('avatar-delete/' . $user->id),
                            [
                                'class' => 'btn',
                                'style' => [
                                    'display' => $user->avatarFile ? '' : 'none',
                                    'width' => '107px',
                                    'margin-top' => '10px',
                                    'color' => '#fff',
                                    'background' => 'red'
                                ]
                            ]
                        ),
                    'options' => [
                        'class' => 'account__redaction-avatar'
                    ],
                    'labelOptions' => ['class' => 'link-regular'],
                    'inputOptions' => ['style' => 'display: none']])->fileInput()
                ?>


                <div class="account__redaction">

                    <?= $form->field($userForm, 'name', [
                            'options' => [
                                'class' => 'field-container account__input account__input--name'
                            ],
                            'inputOptions' => [
                                'class' => 'input textarea',
                                'value' => $user->name,
                                'disabled' => true
                            ]
                        ]
                    ) ?>

                    <?= $form->field($userForm, 'email', [
                            'options' => [
                                'class' => 'field-container account__input account__input--email'
                            ],
                            'inputOptions' => [
                                'class' => 'input textarea',
                                'value' => $user->email,
                            ]
                        ]
                    ) ?>

                    <?= $form->field($userForm, 'city', [
                            'options' => [
                                'class' => 'field-container account__input account__input--address'
                            ]
                        ]
                    )->widget(
                        AutoComplete::className(), [
                        'clientOptions' => [
                            'source' => ArrayHelper::getColumn(Cities::find()->all(), 'name')
                        ],
                        'options' => [
                            'class' => 'input textarea',
                            'value' => $user->city->name,
                            'type' => 'search',
                        ]
                    ]) ?>

                    <?= $form->field($userForm, 'birthday', [
                            'options' => [
                                'class' => 'field-container account__input account__input--date'
                            ],
                            'inputOptions' => [
                                'class' => 'input-middle input input-date',
                                'value' => $user->birthday,
                                'onfocus' => "(this.type='date')"
                            ]
                        ]
                    ) ?>

                    <?= $form->field($userForm, 'aboutMe', [
                            'options' => [
                                'class' => 'field-container account__input account__input--info'
                            ],
                            'inputOptions' => [
                                'class' => 'input textarea',
                                'value' => $user->about_me,
                                'rows' => '7'
                            ]
                        ]
                    )->textarea() ?>
                </div>
            </div>
        </div>
        <h3 class="div-line">Выберите свои специализации</h3>
        <div class="account__redaction-section-wrapper">

            <?= $form->field($userForm, 'category_ids', [
                'template' => '{input}'
            ])->checkboxList($categories, [
                'class' => 'search-task__categories account_checkbox--bottom',
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checked = $checked ? 'checked' : '';
                    return "
                    <label class='checkbox__legend' for='{$index}'>
                        <input class=\"visually-hidden checkbox__input\" id='{$index}' type='checkbox' name='{$name}' value='{$value}' $checked >
                        <span>{$label}</span>
                    </label>";
                }])->label(false);
            ?>
        </div>
        <h3 class="div-line">Безопасность</h3>
        <div class="account__redaction-section-wrapper account__redaction">
            <?= $form->field($userForm, 'password', [
                'options' => [
                    'class' => 'field-container account__input',
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'type' => 'password'
                ]
            ]) ?>
            <?= $form->field($userForm, 'passwordRepeat', [
                'options' => [
                    'class' => 'field-container account__input',
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'type' => 'password',
                ]
            ]) ?>
        </div>

        <?php if (Yii::$app->session->hasFlash('userPassword')): ?>
            <?= Alert::widget([
                'options' => [
                    'class' => 'alert-info'
                ],
                'body' => 'Пароль обновлен'
            ]) ?>
        <?php endif; ?>

        <h3 class="div-line">Фото работ</h3>
        <?php Pjax::begin() ?>
        <div class="account__redaction-section-wrapper account__redaction">

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

        </div>
        <?=
        LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
            'options' => [
                'class' => 'pagination',
                'style' => [
                    'width' => '100%',
                    'display' => 'flex',
                    'justify-content' => 'center'
                ]
            ]
        ]);
        ?>
        <?php Pjax::end() ?>
        <?= $form->field($userForm, 'images[]', [
            'labelOptions' => ['class' => 'link-regular'],
            'inputOptions' => ['style' => 'display: none']
        ])->fileInput(['multiple' => true, 'accept' => 'image/*'])
        ?>

        <?= Html::submitButton('Загрузить', [
            'class' => 'btn'
        ]) ?>

        <h3 class="div-line">Контакты</h3>
        <div class="account__redaction-section-wrapper account__redaction">
            <?= $form->field($userForm, 'phone', [
                'template' => "<div class='field-container account__input'>" . " {label}{input}<span>{error}</span> </div>",

            ])->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999-99-99',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ]
            ])->textInput([
                'class' => 'input textarea',
                'placeholder' => '8 (555) 187 44 87',
                'value' => $user->phone
            ]); ?>
            <?= $form->field($userForm, 'skype', [
                'options' => [
                    'class' => 'field-container account__input',
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'value' => $user->skype
                ]
            ]) ?>
            <?= $form->field($userForm, 'otherContacts', [
                'options' => [
                    'class' => 'field-container account__input',
                ],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'value' => $user->other_contacts
                ]
            ]) ?>
        </div>
        <h3 class="div-line">Настройки сайта</h3>
        <h4>Уведомления</h4>

        <div class="account__redaction-section-wrapper account_section--bottom">
            <div class="search-task__categories account_checkbox--bottom">
                <?= $form->field($userForm, 'notification_new_message', [
                    'labelOptions' => [
                        'class' => 'checkbox__legend'
                    ],
                    'template' => '<label class="checkbox__legend">
                                {input}
                                <span>Новое сообщение</span>
                            </label>',

                ])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'checked' => (bool)$user->notification_new_message
                ],
                    false)->label(false); ?>
                <?= $form->field($userForm, 'notification_task_action', [
                    'labelOptions' => [
                        'class' => 'checkbox__legend'
                    ],
                    'template' => '<label class="checkbox__legend">
                                {input}
                                <span>Действия по заданию</span>
                            </label>'
                ])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'checked' => (bool)$user->notification_task_action
                ],
                    false)->label(false); ?>

                <?= $form->field($userForm, 'notification_new_review', [
                    'labelOptions' => [
                        'class' => 'checkbox__legend'
                    ],
                    'template' => '<label class="checkbox__legend">
                                {input}
                                <span>Новый отзыв</span>
                            </label>',

                ])->checkbox([
                    'class' => 'visually-hidden checkbox__input',
                    'checked' => (bool)$user->notification_new_review
                ],
                    false)->label(false); ?>
            </div>
        </div>
        <div class="search-task__categories account_checkbox account_checkbox--secrecy">


            <?= $form->field($userForm, 'show_contacts', [
                'labelOptions' => [
                    'class' => 'checkbox__legend'
                ],
                'template' => '<label class="checkbox__legend">
                                {input}
                                <span>Показывать мои контакты только заказчику</span>
                            </label>',

            ])->checkbox([
                'class' => 'visually-hidden checkbox__input',
                'checked' => (bool)$user->show_contacts
            ],
                false)->label(false); ?>

            <?= $form->field($userForm, 'hide_profile', [
                'labelOptions' => [
                    'class' => 'checkbox__legend'
                ],
                'template' => '<label class="checkbox__legend">
                                {input}
                                <span>Не показывать мой профиль</span>
                            </label>',

            ])->checkbox([
                'class' => 'visually-hidden checkbox__input',
                'checked' => (bool)$user->hide_profile
            ],
                false)->label(false); ?>
        </div>

        <?= Html::submitButton('Сохранить изменения', [
            'class' => 'button'
        ]) ?>

        <?php ActiveForm::end() ?>
    </section>
</div>

<!--bootstrap4 form style-->
<?= Alert::widget([
    'options' => [
        'style' => [
            'display' => 'none'
        ]
    ]
]) ?>

