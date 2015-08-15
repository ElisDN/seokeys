<?php

namespace tests\codeception\_pages\user;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class EmailConfirmPage extends BasePage
{
    public $route = 'user/default/email-confirm';
}