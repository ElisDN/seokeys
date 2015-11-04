<?php

namespace app\modules\admin;

use yii\base\BootstrapInterface;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$app->i18n->translations['admin*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/admin/messages',
            'fileMap' => [
                'admin' => 'app.php',
            ],
        ];
    }
}