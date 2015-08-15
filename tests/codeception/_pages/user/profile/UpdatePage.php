<?php

namespace tests\codeception\_pages\user\profile;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class UpdatePage extends BasePage
{
    public $route = 'user/profile/update';

    /**
     * @param array $changeData
     */
    public function send($changeData)
    {
        foreach ($changeData as $field => $value) {
            $this->actor->fillField('input[name="ProfileUpdateForm[' . $field . ']"]', $value);
        }
        $this->actor->click('update-button');
    }
}
