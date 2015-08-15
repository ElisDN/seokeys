<?php

namespace tests\codeception\_pages\user;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class PasswordResetPage extends BasePage
{
    public $route = 'user/default/password-reset';

    /**
     * @param string $password
     */
    public function send($password)
    {
        $this->actor->fillField('input[name="PasswordResetForm[password]"]', $password);
        $this->actor->click('reset-button');
    }
}
