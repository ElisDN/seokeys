<?php

namespace tests\codeception\_pages\user;

use yii\codeception\BasePage;

/**
 * Represents login page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class SignupPage extends BasePage
{
    public $route = 'user/default/signup';

    /**
     * @param array $signupData
     */
    public function submit(array $signupData)
    {
        foreach ($signupData as $field => $value) {
            $inputType = $field === 'body' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="SignupForm[' . $field . ']"]', $value);
        }
        $this->actor->click('signup-button');
    }
}