<?php

$config = [
    'id' => 'app-console',
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
            'controllerNamespace' => 'app\modules\user\controllers\console',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
