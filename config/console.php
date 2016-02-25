<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'id' => 'app-console',
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
            'controllerNamespace' => 'app\modules\user\controllers\console',
        ],
    ],
];
