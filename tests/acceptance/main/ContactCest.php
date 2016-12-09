<?php

namespace tests\acceptance\main;

use AcceptanceTester;
use yii\helpers\Url;

class ContactCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(['/main/contact/index']));
    }

    public function open(AcceptanceTester $I)
    {
        $I->seeInTitle('Contact');
    }

    public function submitForm(AcceptanceTester $I)
    {
        $I->fillField('#contactform-name', 'tester');
        $I->fillField('#contactform-email', 'tester@example.com');
        $I->fillField('#contactform-subject', 'test subject');
        $I->fillField('#contactform-body', 'test content');
        $I->fillField('#contactform-verifycode', 'testme');
        $I->wait(1);
        $I->click('contact-button');
        $I->wait(2);

        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }
}
