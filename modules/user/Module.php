<?php

namespace app\modules\user;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $defaultRole = 'user';
    /**
     * @var int
     */
    public $emailConfirmTokenExpire = 259200; // 3 days
    /**
     * @var int
     */
    public $passwordResetTokenExpire = 3600;

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/user/' . $category, $message, $params, $language);
    }
}
