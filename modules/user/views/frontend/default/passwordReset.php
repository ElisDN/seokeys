<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\user\Module;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\forms\frontend\PasswordResetForm */

$this->title = Module::t('module', 'TITLE_PASSWORD_RESET');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('module', 'PLEASE_FILL_FOR_RESET') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'password-reset-form']); ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'reset-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>