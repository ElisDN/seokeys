<?php

namespace app\modules\admin;

use yii\base\Application;
use yii\base\BootstrapInterface;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->registerTranslations($app);
    }

    public function registerTranslations(Application $app)
    {
        $app->i18n->translations['modules/admin/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/admin/messages',
            'fileMap' => [
                'modules/admin/module' => 'module.php',
            ],
        ];
    }
}
