<?php

    use kartik\export\ExportMenu;
    use kartik\grid\GridView;
    use yii\grid\ActionColumn;
    use yii\helpers\Html;
    use yii\widgets\Pjax;

?>
<?php

    $gridColumns = [
        'name:text:Name',
        'age:text:Age',
        [
            'attribute' => 'isRequester',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->isRequester !== null ? 'Yes' : 'No';
            }
        ],
        [
            'attribute' => 'isDonor',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->isDonor !== null ? 'Yes' : 'No';
            }
        ],
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
    Pjax::begin(['id' => 'users-pjax']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'showHeader' => true,
        'pager' => [
            'options' => ['class' => 'pagination'],
            'linkOptions' => [
                'data-context' => 'display-users'
            ],
        ],

        'columns' => [
            'name:text:Name',
            'age:text:Age',
            [
                'attribute' => 'isRequester',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->isRequester !== null ? 'Yes' : 'No';
                }
            ],
            [
                'attribute' => 'isDonor',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->isDonor !== null ? 'Yes' : 'No';
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} ',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('View', ['admin/view', 'id' => $model->id, 'table' => 'user'], [
                            'class' => 'btn btn-success testModal',
                            'title' => 'View',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', $url, [
                            'class' => 'btn btn-danger',
                            'title' => 'Delete',
                            'data-pjax' => '0'

                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('Update', $url, [
                            'class' => 'btn btn-info',
                            'title' => 'Update',
                            'data-pjax' => '0'

                        ]);
                    },

                ],
            ]

        ],
    ]);

    Pjax::end();
?>