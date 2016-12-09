<?php

namespace tests\acceptance\user\profile;

use AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function testAccess(AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(['/user/profile/index']));
        $I->dontSeeInTitle('Profile');
        $I->seeInTitle('Login');
    }

    public function testHomePage(AcceptanceTester $I)
    {
        $I->amLoggedInAsUser();
        $I->amOnPage(Url::to(['/user/profile/index']));
        $I->seeInTitle('Profile');
    }
}
