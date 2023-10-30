<?php
    
    use kartik\export\ExportMenu;
    use kartik\grid\GridView;
    use yii\grid\ActionColumn;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use app\models\User;


?>

<?php
    $gridColumns = [
        ['attribute' => 'user.name', 'format' => 'text', 'label' => 'Name'],
        'blood_group:text:Blood Group',
        'quantity_needed:text:Quantity Needed',
        [
            'attribute' => 'ever_donated_blood',
            'format' => 'raw',
            'label' => 'Ever Donated Blood?',
            'value' => function ($model) {
                return $model->ever_donated_blood == 0 ? 'No' : 'Yes';
            }
        ]
    ];
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_EXCEL => false,
        ],
        'dropdownOptions' => [
            'label' => 'Export All',
            'class' => 'btn btn-outline-secondary btn-default'
        ]
    ])

?>

<?php
    Pjax::begin(['id' => 'request-pjax']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'showHeader' => true,
        'pager' => [
            'options' => ['class' => 'pagination'],
            'linkOptions' => [
                'data-context' => 'display-requests'
            ],
        ],
        'columns' => [
            ['attribute' => 'user.name', 'format' => 'text', 'label' => 'Name'],
            'blood_group:text:Blood Group',
            'quantity_needed:text:Quantity Needed',
            [
                'attribute' => 'ever_donated_blood',
                'format' => 'raw',
                'label' => 'Ever Donated Blood?',
                'value' => function ($model) {
                    return $model->ever_donated_blood == 0 ? 'No' : 'Yes';
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{approve} {deny} {update} {email}',
                'buttons' => [
                    'approve' => function ($url, $model, $key) {
                        $is_approved = $model->approved === 1;
                        return Html::a($is_approved ? 'Approved' : 'Approve', ['user/approve-request', 'id' => $model->id], [
                            'class' => 'btn ' . ($is_approved ? 'btn-success disabled' : 'btn-dark'),
                            'title' => 'Approve',
                            'data-pjax' => '0'
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        $is_approved = $model->approved === 1;
                        return Html::a('Update', $url, [
                            'class' => 'btn btn-info ' . ($is_approved ? 'disabled' : ''),
                            'title' => 'Update',
                            'data-pjax' => '0'

                        ]);
                    },
                    'deny' => function ($url, $model, $key) {
                        $is_approved = $model->approved === 1;
                        return Html::a('Deny', ['user/deny-request', 'id' => $model->id], [
                            'class' => 'btn btn-danger ' . ($is_approved ? 'disabled' : ''),
                            'title' => 'Deny',
                            'data-pjax' => '0'

                        ]);
                    },
                    'email' => function ($url, $model, $key) {
                        $user = User::findOne($model->user_id);
                        $email = $user->email;
                        return Html::a('Email', ['user/email', 'id' => $model->user_id, 'email' => $email], [
                            'class' => 'btn btn-warning',
                            'title' => 'Email',
                            'data-pjax' => '0',
                            'data-toggle' => 'modal',
                            'data-target' => '#email-modal',
                        ]);
                    },


                ],
            ]
        ],
    ]);

    Pjax::end();


?>
