<?php

namespace app\modules\user;

use yii\console\Application as ConsoleApplication;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';
    /**
     * @var int
     */
    public $emailConfirmTokenExpire = 259200; // 3 days
    /**
     * @var int
     */
    public $passwordResetTokenExpire = 3600;

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'app\modules\user\commands';
        }
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/user/' . $category, $message, $params, $language);
    }
}
