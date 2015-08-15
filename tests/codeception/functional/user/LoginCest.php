<?php

namespace tests\codeception\functional\user;

use FunctionalTester;
use tests\codeception\_pages\user\LoginPage;
use tests\codeception\functional\FunctionalCest;

class LoginCest extends FunctionalCest
{
    /**
     * @after logout
     */
    public function testLogin(FunctionalTester $I)
    {
        $I->wantTo('ensure that login works');

        $loginPage = LoginPage::openBy($I);

        $I->seeInTitle('Login');

        $I->amGoingTo('try to login with empty credentials');
        $loginPage->login('', '');
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');

        $I->amGoingTo('try to login with wrong credentials');
        $loginPage->login('admin', 'wrong');
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');

        $I->amGoingTo('try to login with correct credentials');
        $loginPage->login('admin', 'adminpass');
        $I->expectTo('see user info');
        $I->see('Profile', '.nav');
    }
}
