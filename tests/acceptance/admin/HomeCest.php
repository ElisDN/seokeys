<?php

namespace tests\acceptance\admin;

use AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function testAccess(AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(['/admin/default/index']));
        $I->dontSeeInTitle('Control panel');
        $I->seeInTitle('Login');
    }

    public function testHomePage(AcceptanceTester $I)
    {
        $I->amLoggedInAsAdmin();
        $I->amOnPage(Url::to(['/admin/default/index']));
        $I->seeInTitle('Control panel');
    }
}