<?php

namespace app\modules\user;

use app\modules\user\forms\frontend\SignupForm;
use app\modules\user\forms\frontend\PasswordResetForm;
use app\modules\user\forms\frontend\PasswordResetRequestForm;
use app\modules\user\models\query\UserQuery;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->registerDependencies($app);
        $this->registerTranslations($app);
    }

    public function registerTranslations(Application $app)
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

    private function registerDependencies(Application $app)
    {
        $container = \Yii::$container;

        $container->set(PasswordResetRequestForm::class, [], [
            $app->params['user.passwordResetTokenExpire'],
        ]);

        $container->set(SignupForm::class, [], [
            $app->params['user.defaultRole'],
        ]);

        $container->set(PasswordResetForm::class, function ($container, $args) use ($app) {
            return new PasswordResetForm($args[0], $app->params['user.passwordResetTokenExpire']);
        });

        $container->set(UserQuery::class, function ($container, $args) use ($app) {
            return new UserQuery($args[0], $app->params['user.emailConfirmTokenExpire']);
        });
    }
}
