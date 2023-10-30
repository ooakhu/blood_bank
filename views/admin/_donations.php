<?php


    use kartik\export\ExportMenu;
    use yii\grid\ActionColumn;
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\Pjax;


?>

<?php
    $gridColumns = [
        ['attribute' => 'user.name', 'format' => 'text', 'label' => 'Name'],
        'blood_group:text:Blood Group',
        'quantity_donated:text:Qty Donated',
        'useDrugs:boolean:DrugUser?',

        [
            'attribute' => 'drugsUsed',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->drugsUsed !== null ? "$model->drugsUsed" : 'none';
            }

        ],
        'knownDiseases:boolean:Known Illnesses?',
        [
            'attribute' => 'diseases',
            'format' => 'text',
            'label' => 'Illnesses',
            'value' => function ($model) {
                return $model->diseases !== null ? "$model->diseases" : 'none';
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
    Pjax::begin(['id' => 'donate-pjax']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'showHeader' => true,
        'pager' => [
            'options' => ['class' => ' pagination'],
            'linkOptions' => [
                'data-context' => 'display-donations'
            ],
        ],
        'columns' => [
            ['attribute' => 'user.name', 'format' => 'text', 'label' => 'Name'],
            'blood_group:text:Blood Group',
            'quantity_donated:text:Qty Donated',
            'useDrugs:boolean:DrugUser?',

            [
                'attribute' => 'drugsUsed',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->drugsUsed !== null ? "$model->drugsUsed" : 'none';
                }

            ],
            'knownDiseases:boolean:Known Illnesses?',
            [
                'attribute' => 'diseases',
                'format' => 'text',
                'label' => 'Illnesses',
                'value' => function ($model) {
                    return $model->diseases !== null ? "$model->diseases" : 'none';
                }

            ],
            [
                'class' => ActionColumn::class,
                'template' => '{accept} {reject} {update} {email}',
                'buttons' => [
                    'reject' => function ($url, $model, $key) {
                        $is_accepted = $model->accept === 1;
                        return Html::a('Reject', ['user/reject-donation', 'id' => $model->id], [
                            'class' => 'btn btn-danger ' . ($is_accepted ? 'disabled' : ''),
                            'title' => 'Reject',
                            'data-pjax' => '0'
                        ]);
                    },
                    'accept' => function ($url, $model, $key) {
                        $is_accepted = $model->accept === 1;
                        return Html::a($is_accepted ? 'Accepted' : 'Accept', ['user/accept-donation', 'id' => $model->id], [
                            'class' => 'btn ' . ($is_accepted ? 'btn-success disabled' : 'btn-dark'),
                            'title' => 'Accept',
                            'data-pjax' => '0'

                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        $is_accepted = $model->accept === 1;
                        return Html::a('Update', $url, [
                            'class' => 'btn btn-info ' . ($is_accepted ? 'disabled' : ''),
                            'title' => 'Update',
                            'data-pjax' => '0'

                        ]);
                    },
                    'email' => function ($url, $model, $key) {
                        return Html::a('Email', $url, [
                            'class' => 'btn btn-warning',
                            'title' => 'Email',
                            'data-pjax' => '0'

                        ]);
                    },
                ],
            ]
        ],
    ]);

    Pjax::end();


?>
