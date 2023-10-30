<?php

    use yii\helpers\Html;

    /** @var yii\web\View $this */
    /** @var yii\base\Model $model */
    /** @var app\models\User $user */

    //    $this->title = 'Update User: ' . $model->name;
    //    $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
    //    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
    //    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <?php
        $session = Yii::$app->session;
        $errors = $session->getFlash('errorMessages');
        $success = $session->getFlash('successMessage');

        if (isset($errors) && (count($errors) > 0)) {
            foreach ($session->getFlash('errorMessages') as $error) {
                echo "<div class='alert alert-danger' role='alert'>$error[0]</div>";
            }
        }
        if (isset($successMessage)) {
            echo "<div class='alert alert-success' role='alert'>$successMessage</div>";

        }
    ?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
