<?php

namespace app\modules\main;

use yii\base\BootstrapInterface;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$app->i18n->translations['main'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/main/messages',
            'fileMap' => [
                'main' => 'app.php',
            ],
        ];
    }
}