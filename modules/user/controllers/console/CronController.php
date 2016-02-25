<?php

namespace app\modules\user\controllers\console;

use app\modules\user\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Console crontab actions
 */
class CronController extends Controller
{
    /**
     * @var \app\modules\user\Module
     */
    public $module;

    /**
     * Removes non-activated expired users
     */
    public function actionRemoveOverdue()
    {
        foreach (User::find()->overdue($this->module->emailConfirmTokenExpire)->each() as $user) {
            /** @var User $user */
            $this->stdout($user->username);
            if ($user->delete()) {
                Yii::info('Remove expired user ' . $user->username);
                $this->stdout(' OK', Console::FG_GREEN, Console::BOLD);
            } else {
                Yii::warning('Cannot remove expired user ' . $user->username);
                $this->stderr(' FAIL', Console::FG_RED, Console::BOLD);
            }
            $this->stdout(PHP_EOL);
        }

        $this->stdout('Done!', Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }
}