<?php
/**
 * Application configuration for acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/common.php'),
    require(__DIR__ . '/../../../config/common-local.php'),
    require(__DIR__ . '/../../../config/web.php'),
    require(__DIR__ . '/../../../config/web-local.php'),
    require(__DIR__ . '/config.php'),
    require(__DIR__ . '/config-local.php'),
    [

    ]
);
