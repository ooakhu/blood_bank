<?php

    /** @var yii\web\View $this */

    use yii\widgets\ActiveForm;

    $this->title = 'Register';
    $this->params['breadcrumbs'][] = $this->title;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<?php
    $session = Yii::$app->session;
    $errors = $session->getFlash('errorMessages');
    $success = $session->getFlash('successMessage');

    if (isset($errors) && (count($errors) > 0)) {
        foreach ($session->getFlash('errorMessages') as $error) {
            echo "<div class='alert alert-danger' role='alert'>$error[0]</div>";
        }
    }
    if (isset($success)) {
        echo "<div class='alert alert-success' role='alert'>$success</div>";

    }
?>
<h1 class="mb-3 mt-4">Register To Donate Or Request For Blood</h1>

<?php
    ActiveForm::begin([
        'action' => ['site/sign-up'],
        'method' => 'post',
    ]);
?>

<div class='mb-3'>
    <label class='form-label' for="name">Name</label>
    <input id="name" type='text' name='name' placeholder='Name' class='form-control' required>
</div>
<div class='mb-3'>
    <label class='form-label' for="email">Email</label>
    <input id="email" type='email' name='email' placeholder='Email' class='form-control' required>
</div>
<div class='mb-3'>
    <label class='form-label' for="password">Password</label>
    <input id="password" type='password' name='password' placeholder='Password' class='form-control' required>
</div>
<div class='mb-3'>
    <label class='form-label' for="age">Age</label>
    <input id='age' type='number' name='age' placeholder='' class='form-control' required>
</div>
<button type='submit' class='btn btn-primary' name="user_reg">Register</button>

<?php
    ActiveForm::end();
?>
</body>
</html>
