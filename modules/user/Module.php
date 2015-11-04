<?php

namespace app\modules\user;

use yii\console\Application as ConsoleApplication;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';

    public $passwordResetTokenExpire = 3600;

    public $emailConfirmUserExpire = 259200; // 3 days

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'app\modules\user\commands';
        }
    }
}
