<?php

namespace app\modules\contact\controllers;

use app\modules\contact\models\ContactForm;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
	public function actions()
	{
		return [
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		} else {
			return $this->render('index', [
				'model' => $model,
			]);
		}
	}
}
