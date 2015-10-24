<?php

namespace app\modules\admin;

use yii\base\BootstrapInterface;
use yii\filters\AccessControl;
use yii\console\Application as ConsoleApplication;
use Yii;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'app\modules\user\commands';
        }
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/admin/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/admin/messages',
            'fileMap' => [
                'modules/admin/app' => 'app.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/admin/' . $category, $message, $params, $language);
    }
}
