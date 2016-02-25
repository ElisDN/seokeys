<?php

namespace tests\codeception\_pages\admin\users;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class UserCreatePage extends BasePage
{
    public $route = 'admin/users/default/create';

    /**
     * @param array $contactData
     */
    public function submit(array $contactData)
    {
        foreach ($contactData as $field => $value) {
            if ($field === 'status') {
                $this->actor->selectOption('select[name="User[' . $field . ']"]', $value);
            } else {
                $this->actor->fillField('input[name="User[' . $field . ']"]', $value);
            }
        }
        $this->actor->click('submit-button');
    }
}
