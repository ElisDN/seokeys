<?php

use app\modules\user\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\form\ProfileUpdateForm */

$this->title = Module::t('app', 'TITLE_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Module::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
