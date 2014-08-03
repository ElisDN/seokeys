<?php

$config = [
    'id' => 'app',
    'components' => [
		'user' => [
			'identityClass' => 'app\modules\user\models\User',
			'enableAutoLogin' => true,
		],
		'errorHandler' => [
			'errorAction' => 'main/default/error',
		],
		'request' => [
			'cookieValidationKey' => '',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
		],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
