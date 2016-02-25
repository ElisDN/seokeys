<?php

namespace tests\codeception\functional;

use FunctionalTester;
use tests\codeception\_pages\user\LoginPage;
use yii\helpers\Url;

class FunctionalCest
{
    protected function loginAsAdmin(FunctionalTester $I)
    {
        $this->login($I, 'admin', 'adminpass');
    }

    protected function loginAsUser(FunctionalTester $I)
    {
        $this->login($I, 'admin', 'adminpass');
    }

    protected function login(FunctionalTester $I, $name, $password)
    {
        $loginPage = LoginPage::openBy($I);
        $I->seeInTitle('Login');
        $loginPage->login($name, $password);
        $I->see('Logout', '.nav');
    }

    protected function logout(FunctionalTester $I)
    {
        $I->see('Logout', '.nav');
        $I->sendAjaxPostRequest(Url::to(['/user/default/logout']));
        $I->amOnPage('/');
        $I->see('Login', '.nav');
    }
}