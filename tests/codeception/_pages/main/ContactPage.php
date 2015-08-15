<?php

namespace tests\codeception\_pages\main;

use yii\codeception\BasePage;

/**
 * Represents contact page
 * @property \AcceptanceTester|\FunctionalTester $actor
 */
class ContactPage extends BasePage
{
    public $route = 'main/contact/index';

    /**
     * @param array $contactData
     */
    public function submit(array $contactData)
    {
        foreach ($contactData as $field => $value) {
            $inputType = $field === 'body' ? 'textarea' : 'input';
            $this->actor->fillField($inputType . '[name="ContactForm[' . $field . ']"]', $value);
        }
        $this->actor->click('contact-button');
    }
}
