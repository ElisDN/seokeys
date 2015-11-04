<?php

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>

<?= Yii::t('user', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Yii::t('user', 'FOLLOW_TO_CONFIRM_EMAIL') ?>

<?= $confirmLink ?>

<?= Yii::t('user', 'IGNORE_IF_DO_NOT_REGISTER') ?>