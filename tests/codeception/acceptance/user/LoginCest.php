<?php

namespace tests\codeception\acceptance\user;

use AcceptanceTester;
use tests\codeception\_pages\user\LoginPage;
use tests\codeception\acceptance\AcceptanceCest;

class LoginCest extends AcceptanceCest
{
    public function testLogin(AcceptanceTester $I)
    {
        $I->wantTo('ensure that login works');

        $loginPage = LoginPage::openBy($I);

        $I->seeInTitle('Login');

        $I->amGoingTo('try to login with empty credentials');
        $loginPage->login('', '');
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');

        $I->amGoingTo('try to login with wrong credentials');
        $loginPage->login('admin', 'wrong');
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');

        $I->amGoingTo('try to login with correct credentials');
        $loginPage->login('admin', 'adminpass');
        if (method_exists($I, 'wait')) {
            $I->wait(2); // only for selenium
        }
        $I->expectTo('see user info');
        $I->seeLink('Profile', '.nav');
        $I->dontSeeLink('Login', '.nav');
        $I->dontSeeLink('Signup', '.nav');
    }
}