<?php

namespace app\modules\user;

use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\user\controllers';

    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'app\modules\user\commands';
        }
    }
}
