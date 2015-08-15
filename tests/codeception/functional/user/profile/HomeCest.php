<?php

namespace tests\codeception\functional\user\profile;

use FunctionalTester;
use tests\codeception\functional\FunctionalCest;

class HomeCest extends FunctionalCest
{
    public function testAccess(FunctionalTester $I)
    {
        $I->wantTo('ensure that access control works');
        $I->amOnPage(['/user/profile/index']);
        $I->dontSeeInTitle('Profile');
        $I->seeInTitle('Login');
    }

    /**
     * @before loginAsUser
     * @after logout
     */
    public function testHomePage(FunctionalTester $I)
    {
        $I->wantTo('ensure that profile home page works');
        $I->amOnPage(['/user/profile/index']);
        $I->seeInTitle('Profile');
    }
}