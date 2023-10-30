<?php

    /** @var yii\web\View $this */

    /** @var string $content */

    use app\assets\AppAsset;
    use app\assets\MyAsset;
    use app\widgets\Alert;
    use yii\bootstrap5\Html;
    use yii\bootstrap5\Nav;
    use yii\bootstrap5\NavBar;

    MyAsset::register($this);
    AppAsset::register($this);

    $this->registerCsrfMetaTags();
    $this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
    $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
    $this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
    $this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
    $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar navbar-expand-md fixed-top ', 'style' => 'background-color:#b30f30']
        ]);

        $items = [
            ['label' => 'Home', 'url' => ['/site/index']],
            Yii::$app->user->isGuest ? ['label' => 'Contact Us', 'url' => ['/site/contact']] : '',
            Yii::$app->user->isGuest ? ['label' => 'Register', 'url' => ['/site/register']] : '',
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->name . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'

        ];

        if (Yii::$app->user->can('admin')) {
            $items[] = ['label' => 'Admin Dashboard', 'url' => ['admin/admin-dashboard']];
        }

        if (Yii::$app->user->can('user')) {
            $items[] = ['label' => 'Dashboard', 'url' => ['user/dashboard']];
//            $items[] = ['label' => 'My Submissions', 'url' => ['user/user-submissions']];
            $items[] = ['label' => 'My Submissions', 'url' => ['user/user-submissions']];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav d-flex'],
            'items' => $items

        ]);
        NavBar::end();

        echo Html::beginTag('div', ['class' => 'd-flex container-fluid align-items-center justify-content-around update_stick']);
        echo Html::tag('p', 'Subscribe to RSS Feed', ['class' => 'mb-0']);
        echo Html::tag('p', 'First Blood Donation Spot - Organized by SweetPickens LLC.', ['class' => 'mb-0']);
        echo Html::endTag('div')
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container remove">

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">

    </div>
</footer>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
