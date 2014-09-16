<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'id' => 'app-console',
    'bootstrap' => ['gii'],
    'controllerNamespace' => 'app\commands',
];
