<?php

namespace tests\functional;

use \FunctionalTester;
use tests\_fixtures\UserFixture;

class LoginCest
{
    private $formId = '#login-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amOnRoute('user/default/login');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Login');
        $I->seeElement($this->formId);
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('', ''));
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('admin', 'wrong'));
        $I->see('Incorrect username or password.');
    }
    
    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('admin', 'adminpass'));
        $I->dontSeeLink('Login');
        $I->seeLink('Logout');
    }

    private function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }
}
