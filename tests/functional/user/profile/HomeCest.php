<?php

namespace tests\functional\user\profile;

use app\modules\user\models\User;
use FunctionalTester;

class HomeCest
{
    public function access(FunctionalTester $I)
    {
        $I->amOnPage(['/user/profile/index']);
        $I->dontSeeInTitle('Profile');
        $I->seeInTitle('Login');
    }

    public function open(FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabRecord(User::className(), ['username' => 'admin']));
        $I->amOnPage(['/user/profile/index']);
        $I->seeInTitle('Profile');
    }
}