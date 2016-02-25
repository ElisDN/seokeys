<?php

use app\modules\user\Module;
use app\modules\user\models\backend\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\backend\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(User::getStatusesArray()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Module::t('module', 'BUTTON_CREATE') : Module::t('module', 'BUTTON_SAVE'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name' => 'submit-button',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
