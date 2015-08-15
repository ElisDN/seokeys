<?php

namespace tests\codeception\functional\admin;

use FunctionalTester;
use tests\codeception\functional\FunctionalCest;

class HomeCest extends FunctionalCest
{
    public function testAccess(FunctionalTester $I)
    {
        $I->wantTo('ensure that admin home page works');
        $I->amOnPage(['admin/default/index']);
        $I->dontSeeInTitle('Control panel');
        $I->seeInTitle('Login');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function testHomePage(FunctionalTester $I)
    {
        $I->wantTo('ensure that admin home page works');
        $I->amOnPage(['admin/default/index']);
        $I->seeInTitle('Control panel');
        $I->see('Users', 'a.btn-primary');
    }
}