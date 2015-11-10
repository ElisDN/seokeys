<?php

namespace app\modules\user\commands;

use app\modules\user\models\User;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;

/**
 * Console crontab actions
 */
class CronController extends Controller
{
    /**
     * Removes non-activated expired users
     */
    public function actionRemoveOverdue()
    {
        foreach (User::find()->overdue(Yii::$app->params['user.emailConfirmUserExpire'])->each() as $user) {
            /** @var User $user */
            $this->stdout($user->username);
            $user->delete();
            $this->stdout(' OK', Console::FG_GREEN, Console::BOLD);
            $this->stdout(PHP_EOL);
        }

        $this->stdout('Done!', Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }
}