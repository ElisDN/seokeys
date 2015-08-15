<?php

namespace tests\codeception\acceptance\user\profile;

use AcceptanceTester;
use tests\codeception\acceptance\AcceptanceCest;
use yii\helpers\Url;

class HomeCest extends AcceptanceCest
{
    public function testAccess(AcceptanceTester $I)
    {
        $I->wantTo('ensure that access control works');
        $I->amOnPage(Url::to(['/user/profile/index']));
        $I->dontSeeInTitle('Profile');
        $I->seeInTitle('Login');
    }

    /**
     * @before loginAsUser
     */
    public function testHomePage(AcceptanceTester $I)
    {
        $I->wantTo('ensure that profile home page works');
        $I->amOnPage(Url::to(['/user/profile/index']));
        $I->seeInTitle('Profile');
    }
}
