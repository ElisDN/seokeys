<?php

namespace tests\codeception\_pages\user;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class PasswordResetRequestPage extends BasePage
{
    public $route = 'user/default/password-reset-request';

    /**
     * @param string $email
     */
    public function send($email)
    {
        $this->actor->fillField('input[name="PasswordResetRequestForm[email]"]', $email);
        $this->actor->click('reset-button');
    }
}
