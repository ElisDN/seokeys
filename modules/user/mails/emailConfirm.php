<?php

use app\modules\user\Module;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>

<?= Module::t('app', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Module::t('app', 'FOLLOW_TO_CONFIRM_EMAIL') ?>

<?= $confirmLink ?>

<?= Module::t('app', 'IGNORE_IF_DO_NOT_REGISTER') ?>