<?php

namespace app\modules\user;

use app\modules\user\models\PasswordResetForm;
use app\modules\user\models\PasswordResetRequestForm;
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
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/user/messages',
            'fileMap' => [
                'modules/user/app' => 'app.php',
            ],
        ];
    }

    private function registerDependencies(Application $app)
    {
        $container = Yii::$container;

        $container->set(PasswordResetRequestForm::class, [], [
            $app->params['user.passwordResetTokenExpire'],
        ]);

        $container->set(PasswordResetForm::class, function ($container, $args) use ($app) {
            return new PasswordResetForm($args[0], $app->params['user.passwordResetTokenExpire']);
        });
    }
}
