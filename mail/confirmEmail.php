<?php

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/confirm-email', 'token' => $user->email_confirm_token]);
?>

<?= Yii::t('app', 'Hello, {username}!', ['username' => $user->username]); ?>

<?= Yii::t('app', 'Follow the link below to confirm your email:') ?>

<?= $confirmLink ?>

<?= Yii::t('app', 'If you do not register on our site just remove this mail.') ?>