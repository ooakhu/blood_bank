<?php

    /** @var yii\web\View $this */

    use yii\helpers\Html;


    $this->title = 'Home';
?>
<div class="site-index d-flex flex-column mt-5">

    <div class="container d-flex justify-content-center align-items-center ">
        <?php
            echo Html::img('@web/images/blood.webp', ['alt' => 'Donate Blood Image', 'class' => 'image'])
        ?>
    </div>

    <div class=" container d-flex flex-column justify-content-center align-items-center">

        <h1 style="color: #333333;" class="mb-3">Welcome to BloodBank & Donor Management System</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>The need for blood</h5>
                        <p class='card-text'>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown
                            printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                </div>

            </div>
            <div class='col'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Blood Tips</h5>
                        <p class='card-text'>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown
                            printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                </div>
            </div>
            <div class='col'>
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>Who you could help</h5>
                        <p class='card-text'>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                            unknown
                            printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="recent_donors">


    </div>
</div>
