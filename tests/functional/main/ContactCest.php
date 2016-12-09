<?php

namespace tests\functional;

use \FunctionalTester;

class ContactCest
{
    private $formId = '#contact-form';

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('main/contact/index');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Contact');
    }

    public function submitNoData(FunctionalTester $I)
    {
        $I->submitForm($this->formId, []);
        $I->seeInTitle('Contact');
        $I->see('Your Name cannot be blank');
        $I->see('Your Email cannot be blank');
        $I->see('Subject cannot be blank');
        $I->see('Message cannot be blank');
        $I->see('The verification code is incorrect');
    }

    public function submitNotCorrectEmail(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->see('Your Email is not a valid email address.');
    }

    public function submitCorrectData(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }

    public function noAutoFillForGuest(FunctionalTester $I)
    {
        $I->seeElement('#contact-form');
        $I->seeInField('input[name="ContactForm[name]"]', '');
        $I->seeInField('input[name="ContactForm[email]"]', '');

    }

    public function autoFillForLoggedUser(FunctionalTester $I)
    {
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('main/contact/index');
        $I->seeElement('#contact-form');
        $I->seeInField('input[name="ContactForm[name]"]', 'admin');
        $I->seeInField('input[name="ContactForm[email]"]', 'admin@example.com');
    }
}
