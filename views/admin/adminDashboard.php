<?php

    /** @var yii\web\View $this */

    use app\models\DonateBlood;
    use app\models\RequestBlood;
    use app\models\User;
    use app\widgets\BoxWidget;
    use app\widgets\CustomAlert;

?>



<?php
    echo CustomAlert::widget();
?>

<?php
    yii\bootstrap5\Modal::begin(['id' => 'modal']);
    yii\bootstrap5\Modal::end();
?>

<div class='container-fluid ' id="admin">
    <div class='row'>
        <div class='col-sm ad_dash_head d-flex justify-content-between '>

            <?php BoxWidget::begin(['width' => '250px', 'height' => '100px']);
                $name = Yii::$app->user->identity->name;
                echo "<p class='text-center'>Welcome to your dashboard, {$name}.</p>"
            ?>

            <?php BoxWidget::end() ?>

            <?php BoxWidget::begin(['width' => '250px', 'height' => '100px']);
                $num_of_users = User::getAll();
                echo "<button id='loadUsers' class='btn btn-primary'>
                    Users <span class='badge bg-dark'>$num_of_users</span>
                </button>"
            ?>

            <?php BoxWidget::end() ?>

            <?php BoxWidget::begin(['width' => '250px', 'height' => '100px']);
                $num_requests = RequestBlood::getAll();
                echo "<button id='loadRequests' class='btn btn-primary'>
                    Requests <span class='badge bg-dark'>$num_requests</span>
                </button>"
            ?>

            <?php BoxWidget::end() ?>

            <?php BoxWidget::begin(['width' => '250px', 'height' => '100px']);
                $num_donations = DonateBlood::getAll();
                echo "<button id='loadDonations' class='btn btn-primary'>
                    Donations <span class='badge bg-dark'>$num_donations</span>
                </button>"
            ?>

            <?php BoxWidget::end() ?>

        </div>
    </div>
    <div class='row'>
        <div class='col-2 ad_dash_side d-flex flex-column justify-content-between align-items-start'>
            <?php BoxWidget::begin(['width' => '120px', 'height' => '80px']) ?>
            <strong>Approved</strong>
            <?php BoxWidget::end() ?>

            <?php BoxWidget::begin(['width' => '120px', 'height' => '80px']) ?>
            <strong>Rejected</strong>
            <?php BoxWidget::end() ?>

            <?php BoxWidget::begin(['width' => '120px', 'height' => '80px']) ?>
            <strong>Billing</strong>

            <?php BoxWidget::end() ?>

            <?php BoxWidget::begin(['width' => '120px', 'height' => '80px']) ?>
            <strong>Stats</strong>

            <?php BoxWidget::end() ?>

        </div>
        <div id="ad_dash_main" class='col-10 ad_dash_main'>

        </div>
    </div>
    <?php
        $this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});"); ?>


