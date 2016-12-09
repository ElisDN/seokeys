<?php

namespace tests\acceptance\user;

use AcceptanceTester;
use tests\_fixtures\UserFixture;
use yii\helpers\Url;

class SignupCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amOnPage(Url::to(['/user/default/signup']));
    }

    public function signupSuccessfully(AcceptanceTester $I)
    {
        $I->seeInTitle('Signup');

        $I->fillField('#signupform-username', 'tester');
        $I->fillField('#signupform-email', 'tester.email@example.com');
        $I->fillField('#signupform-password', 'tester_password');
        $I->fillField('#signupform-verifycode', 'testme');
        $I->wait(1);
        $I->click('signup-button');
        $I->wait(2);

        $I->see('Please confirm your Email.', '.alert-success');
    }
}