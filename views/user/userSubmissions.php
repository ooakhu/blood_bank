<?php
    /** @var yii\web\View $this */
    /** @var app\models\RequestBlood $request */

    /** @var app\models\DonateBlood $donate */

    use app\assets\MyAsset;
    use app\widgets\CustomAlert;
    use kartik\export\ExportMenu;
    use kartik\grid\GridView;
    use yii\grid\ActionColumn;
    use yii\helpers\Html;

    $this->title = 'My Submissions';
    MyAsset::register($this);
?>

<?php
    echo CustomAlert::widget();
?>
<?php
    yii\bootstrap5\Modal::begin(['id' => 'modal']);
    yii\bootstrap5\Modal::end();
?>
<h1 class='text-center'>My Requests</h1>

<div id="user-requests">
    <?php
        $gridColumns = [
            ['attribute' => 'user.name', 'format' => 'text', 'label' => 'Name'],
            'blood_group:text:Blood Group',
            'quantity_needed:text:Quantity Needed',
            [
                'attribute' => 'ever_donated_blood',
                'format' => 'raw',
                'label' => 'Ever Donated Blood?',
                'value' => function ($request) {
                    return $request->ever_donated_blood == 0 ? 'No' : 'Yes';
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $request, $key) {
                        return Html::a('View', ['user/view', 'id' => $request->id, 'table' => 'requestblood'], [
                            'class' => 'btn btn-success popupModal',
                            'title' => 'View',

                        ]);
                    },
                    'update' => function ($url, $request, $key) {
                        $is_approved = $request->approved === 1;
                        $is_denied = $request->denied === 1;
                        return Html::a('Update', ['user/update', 'id' => $request->id, 'table' => 'requestblood'], [
                            'class' => 'btn btn-warning popupModal ' . (($is_approved || $is_denied) ? 'disabled' : ''),
                            'title' => 'Update',

                        ]);
                    },
                    'delete' => function ($url, $request, $key) {
                        $is_approved = $request->approved === 1;
                        $is_denied = $request->denied === 1;
                        return Html::a('Delete', $url, [
                            'class' => 'btn btn-danger ' . (($is_approved || $is_denied) ? 'disabled' : ''),
                            'title' => 'delete',
                        ]);
                    }
                ],

            ]

        ];

        echo ExportMenu::widget([
            'dataProvider' => $requestDataProvider,
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
    <?= GridView::widget([
        'dataProvider' => $requestDataProvider,
        'showHeader' => true,
        'columns' => $gridColumns
    ]); ?>
</div>

<h1 class='text-center'>My Donations</h1>
<div id="user-donations">
    <?php
        $gridColumns2 = [
            ['attribute' => 'user.name', 'format' => 'text', 'label' => 'Name'],
            'blood_group:text:Blood Group',
            'quantity_donated:text:Qty Donated',
            'useDrugs:boolean:DrugUser?',
            [
                'attribute' => 'drugsUsed',
                'format' => 'raw',
                'value' => function ($donate) {
                    return $donate->drugsUsed !== null ? "$donate->drugsUsed" : 'none';
                }
            ],
            'knownDiseases:boolean:Known Illnesses?',
            [
                'attribute' => 'diseases',
                'format' => 'text',
                'label' => 'Illnesses',
                'value' => function ($donate) {
                    return $donate->diseases !== null ? "$donate->diseases" : 'none';
                }
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $donate, $key) {
                        return Html::a('View', ['user/view', 'id' => $donate->id, 'table' => 'donateblood'], [
                            'class' => 'btn btn-success popupModal',
                            'title' => 'View',
                        ]);
                    },
                    'update' => function ($url, $donate, $key) {
                        $is_approved = $donate->accept === 1;
                        $is_denied = $donate->reject === 1;
                        return Html::a('Update', ['user/update', 'id' => $donate->id, 'table' => 'donateblood'], [
                            'class' => 'btn btn-warning popupModal ' . (($is_approved || $is_denied) ? 'disabled' : ''),
                            'title' => 'Update',
                        ]);
                    },
                    'delete' => function ($url, $donate, $key) {
                        $is_approved = $donate->accept === 1;
                        $is_denied = $donate->reject === 1;
                        return Html::a('Delete', $url, [
                            'class' => 'btn btn-danger ' . (($is_approved || $is_denied) ? 'disabled' : ''),
                            'title' => 'delete',
                        ]);
                    }
                ],

            ]

        ];
        echo ExportMenu::widget([
            'dataProvider' => $donateDataProvider,
            'columns' => $gridColumns2,
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
    <?= GridView::widget([
        'dataProvider' => $donateDataProvider,
        'showHeader' => true,
        'columns' => $gridColumns2

    ]); ?>

</div>

<?php
    $this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});");
?>
