<?php

    use app\widgets\FormWidget;
    use yii\helpers\Html;

    /** @var yii\web\View $this */
    /** @var app\models\ $model */
    /** @var yii\widgets\ActiveForm $form */
    /** @var app\models\User $user */


?>

<div class="user-form move">

    <?php echo FormWidget::widget(['model' => $model]);

    ?>


</div>

