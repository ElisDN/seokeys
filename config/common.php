<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'SeoKeys',
    'language'=>'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'main/default/index',
                'contact' => 'main/contact/index',
                '<_a:error>' => 'main/default/<_a>',
                '<_a:(login|logout|signup|confirm-email|request-password-reset|reset-password)>' => 'user/default/<_a>',

                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<id:\d+>' => '<_m>/default/view',
                '<_m:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_m>/default/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w-]+>' => '<_m>/<_c>/<_a>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
    ],
    'params' => $params,
];