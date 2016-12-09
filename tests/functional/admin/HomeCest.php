<?php

namespace tests\functional\admin;

use app\modules\user\models\User;
use FunctionalTester;

class HomeCest
{
    public function testAccess(FunctionalTester $I)
    {
        $I->amOnPage(['admin/default/index']);
        $I->dontSeeInTitle('Control panel');
        $I->seeInTitle('Login');
    }

    public function testHomePage(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord(User::className(), ['username' => 'admin']));
        $I->amOnPage(['admin/default/index']);
        $I->seeInTitle('Control panel');
        $I->see('Users', 'a.btn-primary');
    }
}