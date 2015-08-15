<?php

namespace tests\codeception\_pages\user\profile;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class PasswordChangePage extends BasePage
{
    public $route = 'user/profile/password-change';

    /**
     * @param array $changeData
     */
    public function send($changeData)
    {
        foreach ($changeData as $field => $value) {
            $this->actor->fillField('input[name="PasswordChangeForm[' . $field . ']"]', $value);
        }
        $this->actor->click('change-button');
    }
}
