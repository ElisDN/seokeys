<?php

namespace tests\acceptance\user;

use AcceptanceTester;
use tests\_fixtures\UserFixture;
use yii\helpers\Url;

class PasswordResetCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amOnPage(Url::to(['/user/default/password-reset-request']));
    }

    public function requestSuccessfully(AcceptanceTester $I)
    {
        $I->seeInTitle('Reset password');

        $I->seeElement('#password-reset-request-form');

        $I->fillField('#passwordresetrequestform-email', 'reset@example.com');
        $I->click('reset-button');
        $I->wait(2);

        $I->see('Follow the link on mail to reset your password.', '.alert-success');
    }
}