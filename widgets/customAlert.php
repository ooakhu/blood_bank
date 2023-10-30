<?php

    namespace app\widgets;

    use Yii;
    use yii\base\Widget;

    class CustomAlert extends Widget
    {
        public function run()
        {
            $session = Yii::$app->session;
            $errors = $session->getFlash('errorMessages');
            $success = $session->getFlash('successMessage');

            $output = '';

            if (isset($errors) && (count($errors) > 0)) {
                foreach ($session->getFlash('errorMessages') as $error) {
                    $output .= "<div class='alert alert-danger' role='alert'>$error[0]</div>";
                }
            }

            if (isset($success)) {
                $output .= "<div class='alert alert-success' role='alert'>$success</div>";
            }

            return $output;
        }
    }
