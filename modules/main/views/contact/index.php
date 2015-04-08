<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\main\models\ContactForm */

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-contact-index">
	<h1><?= Html::encode($this->title) ?></h1>

	<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

		<div class="alert alert-success">
			Спасибо! Мы свяжемся с Вами в скором  времени.
		</div>

	<?php else: ?>

		<div class="row">
			<div class="col-lg-5">
				<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
				<?= $form->field($model, 'name') ?>
				<?= $form->field($model, 'email') ?>
				<?= $form->field($model, 'subject') ?>
				<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'captchaAction' => '/main/contact/captcha',
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
				]) ?>
				<div class="form-group">
					<?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>

	<?php endif; ?>
</div>
