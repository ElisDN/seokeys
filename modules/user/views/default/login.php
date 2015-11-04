<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\form\LoginForm */

$this->title = Yii::t('user', 'TITLE_LOGIN');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('user', 'PLEASE_FILL_FOR_LOGIN') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?= Html::a(Yii::t('user', 'LINK_PASSWORD_RESET'), ['password-reset-request']) ?>.
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('user', 'USER_BUTTON_LOGIN'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
