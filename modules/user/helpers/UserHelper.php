<?php

namespace app\modules\user\helpers;

use Yii;

class UserHelper
{
    /**
     * @return string
     */
    public static function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @param string $token password reset token
     * @param $timeout
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token, $timeout)
    {
        if (empty($token)) {
            return false;
        }
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $timeout >= time();
    }
} 