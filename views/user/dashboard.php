<?php

    /** @var yii\web\View $this */

    use yii\widgets\ActiveForm;

    $this->title = 'Dashboard';
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

<?php
    $name = Yii::$app->user->identity->name;
    echo "<h1 class='text-center mt-4'>Welcome, {$name}.</h1>"
?>
<div class="container d-flex justify-content-around">
    <div id="donate_blood">
        <h3>Fill the form below to donate blood</h3>
        <?php
            ActiveForm::begin(['action' => ['user/donate-blood'], 'method' => 'post',]);
        ?>
        <div class='mb-3'>
            <label for='blood_group' class='form-label'>What is your blood group?</label>
            <select id='blood_group' name='blood_group' class="form-select">
                <option value='A+'>A Positive</option>
                <option value='A-'>A Negative</option>
                <option value='B+'>B Positive</option>
                <option value='B-'>B Negative</option>
                <option value='O+'>O Positive</option>
                <option value='O-'>O Negative</option>
                <option value='AB+'>AB Positive</option>
                <option value='AB-'>AB Negative</option>
            </select>
        </div>
        <div class='mb-3'>
            <label class='form-label' for="use_drug">Do you use any recreational drugs</label>
            <select name='useDrugs' id='use_drug' class="form-select">
                <option value='No'>No</option>
                <option value='Yes'>Yes</option>
            </select>
        </div>
        <div class='mb-3 d-none use_drug'>
            <label class='form-label' for="drugsUsed">Which drugs do you use?</label>
            <textarea id="drugsUsed" rows="1" cols="4" name='drugsUsed' class='form-control '></textarea>
        </div>
        <div class='mb-3'>
            <label class='form-label' for='knownDiseases'>Do you have any illnesses?</label>
            <select name='knownDiseases' id='knownDiseases' class="form-select">
                <option value='No'>No</option>
                <option value='Yes'>Yes</option>
            </select>
        </div>
        <div class='mb-3 d-none knownDiseases'>
            <label class='form-label' for='diseases'>List all illnesses</label>
            <textarea id='diseases' rows='1' cols='4' name='diseases' class='form-control'></textarea>
        </div>
        <div class='mb-3'>
            <label class='form-label' for='quantity_donated'>Quantity Donated</label>
            <input class="form-control" type="number" name="quantity_donated" id="quantity_donated" value="1" readonly>
        </div>

        <button type='submit' id="donate" class='btn btn-primary' name="">Donate</button>

        <?php
            ActiveForm::end();
        ?>

    </div>
    <div id="request_blood">

        <h3>Fill the form below to request blood</h3>

        <?php
            ActiveForm::begin(['action' => ['user/request-blood'], 'method' => 'post',]);
        ?>

        <div class='mb-3'>
            <div class='mb-3'>
                <label for="ever_donated_blood" class="form-label">
                    Have you ever donated blood?
                    <select name="ever_donated_blood" id="ever_donated_blood" class="form-select">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </label>
            </div>

            <div class='mb-3'>
                <label for="reason" class="form-label">
                    Why do you need blood?
                    <input type="text" id="reason" name="reason" class="form-control">
                </label>
            </div>
            <div class='mb-3'>
                <label for="blood_group" class='form-label'>What blood group is needed?</label>
                <select id='blood_group' name="blood_group" class="form-select">
                    <option value='A+'>A Positive</option>
                    <option value='A-'>A Negative</option>
                    <option value='B+'>B Positive</option>
                    <option value='B-'>B Negative</option>
                    <option value='O+'>O Positive</option>
                    <option value='O-'>O Negative</option>
                    <option value='AB+'>AB Positive</option>
                    <option value='AB-'>AB Negative</option>
                </select>
            </div>
            <div class='mb-3'>
                <label for="quantity_needed" class='form-label'>How many pints do you need?</label>
                <input id="quantity_needed" type='number' name='quantity_needed' class='form-control' max="5" required
                       placeholder="min 1 max 5">
            </div>
            <div class='mb-3'>
                <label for='phone_number' class='form-label'>Mobile Phone Number</label>
                <input id='phone_number' type='text' name='phone_number' class='form-control'>
            </div>
            <div class='mb-3'>
                <label for="institution_or_personal" class='form-label'>Are you an institution or individual?</label>
                <select name='institution_or_personal' id='institution_or_personal' class="form-select">
                    <option value="I'm an institution">I'm an institution</option>
                    <option value='Individual'>I'm an Individual</option>
                </select>
            </div>
            <button type='submit' class='btn btn-primary' name="request">Request</button>

            <?php
                ActiveForm::end();
            ?>

        </div>
    </div>

</body>
</html>
