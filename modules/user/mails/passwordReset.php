<?php

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/password-reset', 'token' => $user->password_reset_token]);
?>

<?= Yii::t('main', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Yii::t('main', 'FOLLOW_TO_RESET_PASSWORD') ?>

<?= $resetLink ?>