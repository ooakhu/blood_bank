<?php

    use app\widgets\CustomAlert;
    use yii\helpers\Html;

    /** @var yii\web\View $this */
    /** @var yii\base\Model $model */
    /** @var app\models\User $user */
?>
<div class="user-update">

    <?php
        echo CustomAlert::widget();
    ?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>
</div>
