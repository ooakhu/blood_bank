<?php

    /** @var yii\web\View $this */
    /** @var yii\bootstrap5\ActiveForm $form */

    /** @var app\models\User $user */

    use app\assets\MyAsset;
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Modal;
    use yii\web\YiiAsset;

    YiiAsset::register($this);
    MyAsset::register($this);

?>

<div class="email_view">
    <?php
        Modal::begin([
            'id' => 'email-modal',
            'title' => '<h2>Send Email</h2>',
            'size' => 'modal-lg',
//            'toggleButton' => ['label' => 'click me'],
            'closeButton' => false,
            'options' => [
                'class' => 'show',
                'role' => 'dialog',
                'style' => 'display: block;',
                'aria-modal' => 'true',
            ]

        ]);

        echo Html::beginForm(['user/send-email'], 'post', [
            'class' => 'mb-3',
        ]);
        echo Html::label('Email Address', 'email', ['class' => 'form-label']);
        echo Html::textInput('email', $email, ['class' => 'form-control']);
        echo Html::label('body');
        echo Html::textarea('body', '', ['rows' => 4, 'class' => 'form-control']);
        echo Html::button('Send', [
            'class' => ['btn btn-warning btn-lg'], 'type' => 'submit',
        ]);
        echo Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-info btn-lg']);

        echo Html::endForm();
        Modal::end()
    ?>
</div>










