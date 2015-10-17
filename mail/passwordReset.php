<?php

/* @var $this yii\web\View */
/* @var $user \app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/password-reset', 'token' => $user->password_reset_token]);
?>

<?= Yii::t('app', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Yii::t('app', 'FOLLOW_TO_RESET_PASSWORD') ?>

<?= $resetLink ?>