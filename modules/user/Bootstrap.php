<?php

namespace app\modules\user;

use app\modules\user\models\query\UserQuery;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;
use yii\di\Container;
use Yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->initTranslations($app);
        $this->initContainer(Yii::$container);
    }

    public function initTranslations(Application $app)
    {
        $app->i18n->translations['modules/user/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/user/messages',
            'fileMap' => [
                'modules/user/module' => 'module.php',
            ],
        ];
    }

    public function initContainer(Container $container)
    {
        $container->set(UserQuery::className(), function ($container, $params, $config) {
            $params[1] = isset($params[1]) ? $params[1] : [];
            $timeout = $this->getModule()->emailConfirmTokenExpire;
            return new UserQuery($params[0], $timeout, ArrayHelper::merge($params[1], $config));
        });
    }

    /**
     * @return Module
     */
    private function getModule()
    {
        return Yii::$app->getModule('user');
    }
}