<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\ChangePasswordForm */

$this->title = Yii::t('app', 'TITLE_CHANGE_PASSWORD');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-change-password">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
