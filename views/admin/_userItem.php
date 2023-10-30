<?php

    use yii\helpers\Html;
    use yii\helpers\Inflector;
    use yii\web\YiiAsset;
    use yii\widgets\DetailView;

    /** @var yii\web\View $this */
    /** @var yii\base\Model $model */

    //get model class name

    $modelClassName = $model::class;
    $this->params['breadcrumbs'][] = ['label' => Inflector::pluralize("$modelClassName"), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
    YiiAsset::register($this);
?>
<div class="<?= strtolower($modelClassName) ?>-view">


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['site/admin-dashboard'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php

        $attributes = [
            'updated_at',
            'created_at',
        ];

        if ($model instanceof app\models\User) {
            $attributes[] = 'id';
            $attributes[] = 'name';
            $attributes[] = 'email:email';
            $attributes[] = 'age';
            $attributes[] = 'phone_number';
            $attributes[] = 'isDonor';
            $attributes[] = 'isRequester';

            // Add user-specific attributes here
        } elseif ($model instanceof app\models\RequestBlood) {
            $attributes[] = 'user.name:text:Name';
            $attributes[] = 'blood_group';
            $attributes[] = 'reason';
            $attributes[] = 'quantity_needed';
            $attributes[] = 'ever_donated_blood:boolean:Ever Donated Blood?';
            $attributes[] = 'institution_or_personal';

        } elseif ($model instanceof app\models\DonateBlood) {
            $attributes[] = 'user.name:text:Name';
            $attributes[] = 'useDrugs:boolean:DrugUser?';
            $attributes[] = 'drugsUsed:text';
            $attributes[] = 'knownDiseases:boolean:Known Illnesses?';
            $attributes[] = 'diseases:text:Illnesses';
            $attributes[] = 'quantity_donated:text:Qty Donated';
        }


    ?>

    <?= $person = DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]) ?>

</div>
