<?php

namespace app\modules\main;

use yii\console\Application as ConsoleApplication;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\main\controllers';

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'app\modules\main\commands';
        }
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/main/' . $category, $message, $params, $language);
    }
}
