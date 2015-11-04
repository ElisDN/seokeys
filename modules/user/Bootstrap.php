<?php

namespace app\modules\user;

use yii\base\BootstrapInterface;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$app->i18n->translations['user'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/user/messages',
            'fileMap' => [
                'user' => 'app.php',
            ],
        ];
    }
}