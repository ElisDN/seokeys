<?php

namespace tests\codeception\acceptance\main;

use AcceptanceTester;
use tests\codeception\_pages\main\ContactPage;
use tests\codeception\acceptance\AcceptanceCest;

class ContactCest extends AcceptanceCest
{
    public function testContact(AcceptanceTester $I)
    {
        $I->wantTo('ensure that contact works');

        $contactPage = ContactPage::openBy($I);

        $I->seeInTitle('Contact');

        $I->amGoingTo('submit contact form with no data');
        $contactPage->submit([]);
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->seeInTitle('Contact');
        $I->see('Name cannot be blank');
        $I->see('Email cannot be blank');
        $I->see('Subject cannot be blank');
        $I->see('Message cannot be blank');
        $I->see('The verification code is incorrect');

        $I->amGoingTo('submit contact form with not correct email');
        $contactPage->submit([
            'name' => 'tester',
            'email' => 'tester.email',
            'subject' => 'test subject',
            'body' => 'test content',
            'verifyCode' => 'testme',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see that email adress is wrong');
        $I->dontSee('Name cannot be blank', '.help-inline');
        $I->see('Email is not a valid email address.');
        $I->dontSee('Subject cannot be blank', '.help-inline');
        $I->dontSee('Message cannot be blank', '.help-inline');
        $I->dontSee('The verification code is incorrect', '.help-inline');

        $I->amGoingTo('submit contact form with correct data');
        $contactPage = ContactPage::openBy($I);
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $contactPage->submit([
            'name' => 'tester',
            'email' => 'tester@example.com',
            'subject' => 'test subject',
            'body' => 'test content',
            'verifyCode' => 'testme',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(2); // only for selenium
        }
        $I->dontSeeElement('#contact-form');
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }

    public function testAutoFill(AcceptanceTester $I)
    {
        $I->wantTo('ensure that contact auto field fill works');

        $I->amGoingTo('check that form is empty for guest');
        $I->expectTo('see empty form fields');
        ContactPage::openBy($I);
        $I->seeInTitle('Contact');
        $I->seeElement('#contact-form');
        $I->seeInField('input[name="ContactForm[name]"]', '');
        $I->seeInField('input[name="ContactForm[email]"]', '');

        $I->amGoingTo('check that form is not empty for user');
        $this->login($I, 'admin', 'adminpass');
        $I->expectTo('see user data in form fields');
        ContactPage::openBy($I);
        $I->seeInTitle('Contact');
        $I->seeElement('#contact-form');
        $I->seeInField('input[name="ContactForm[name]"]', 'admin');
        $I->seeInField('input[name="ContactForm[email]"]', 'admin@example.com');
    }
}

