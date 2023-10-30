<?php

    namespace app\widgets;

    use app\models\DonateBlood;
    use app\models\RequestBlood;
    use app\models\User;
    use Yii;
    use yii\base\Widget;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    class FormWidget extends Widget
    {
        public $model;
        public $form;
        public $user;
        public $submitButtonLabel = 'Save';


        public function init()
        {
            parent::init();

            if (!$this->form) {
                $this->form = ActiveForm::begin(['method' => 'post']);
            }
        }

        public function run()
        {

            if ($this->model instanceof User) {
                echo $this->form->field($this->model, 'name');
                echo $this->form->field($this->model, 'email');
                echo $this->form->field($this->model, 'age');
                echo $this->form->field($this->model, 'phone_number');

            } elseif ($this->model instanceof RequestBlood) {
                $name = $this->model->getUserName();
                echo Html::input('text', 'name', $name, ['readonly' => true, 'class' => 'form-control']);
                echo $this->form->field($this->model, 'blood_group');
                echo $this->form->field($this->model, 'quantity_needed');
                echo $this->form->field($this->model, 'institution_or_personal');

            } elseif ($this->model instanceof DonateBlood) {
                $name = $this->model->getUserName();
                echo Html::input('text', 'name', $name, ['readonly' => true, 'class' => 'form-control']);
                echo $this->form->field($this->model, 'blood_group');
                echo $this->form->field($this->model, 'useDrugs');
                echo $this->form->field($this->model, 'knownDiseases');

            }

            echo Html::submitButton($this->submitButtonLabel, ['class' => 'btn btn-success']);
            echo Html::a('Cancel', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-info ']);

            ActiveForm::end();


        }
    }


    ?>