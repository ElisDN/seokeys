<?php

namespace tests\acceptance\user;

use AcceptanceTester;
use tests\_fixtures\UserFixture;
use yii\helpers\Url;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amOnPage(Url::to(['/user/default/login']));
    }

    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->seeInTitle('Login');

        $I->fillField('#loginform-username', 'admin');
        $I->fillField('#loginform-password', 'adminpass');
        $I->wait(1);
        $I->click('login-button');
        $I->wait(2);

        $I->see('Profile', '.nav');
    }
}