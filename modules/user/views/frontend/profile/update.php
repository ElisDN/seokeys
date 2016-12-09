<?php

use yii\bootstrap\ActiveForm;
use app\modules\user\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\forms\frontend\ProfileUpdateForm */

$this->title = Module::t('module', 'TITLE_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(['id' => 'profile-update-form']); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Module::t('module', 'BUTTON_SAVE'), ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
