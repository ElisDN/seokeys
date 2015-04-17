<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => array_filter([
            ['label' => Yii::t('app/menu', 'Home'), 'url' => ['/main/default/index']],
            ['label' => Yii::t('app/menu', 'Contact'), 'url' => ['/main/contact/index']],
            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app/menu', 'Signup'), 'url' => ['/user/default/signup']] :
                false,
            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app/menu', 'Login'), 'url' => ['/user/default/login']] :
                false,
            !Yii::$app->user->isGuest ?
                ['label' => Yii::t('app/menu', 'Profile'), 'url' => ['/user/profile/index']] :
                false,
            !Yii::$app->user->isGuest ? (
                '<li>'
                . Html::beginForm(['/user/default/logout'], 'post')
                . Html::submitButton(
                    Yii::t('app/menu', 'Logout'),
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ) : false,
        ]),
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?></p>
        <p class="pull-right"><?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
