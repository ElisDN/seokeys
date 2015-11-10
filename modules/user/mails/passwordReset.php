<?php

use app\modules\main\Module;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/password-reset', 'token' => $user->password_reset_token]);
?>

<?= Module::t('module', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Module::t('module', 'FOLLOW_TO_RESET_PASSWORD') ?>

<?= $resetLink ?>