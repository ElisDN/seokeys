<?php

namespace tests\codeception\acceptance\admin;

use AcceptanceTester;
use tests\codeception\acceptance\AcceptanceCest;
use yii\helpers\Url;

class HomeCest extends AcceptanceCest
{
    public function testAccess(AcceptanceTester $I)
    {
        $I->wantTo('ensure that access control works');
        $I->amOnPage(Url::to(['/admin/default/index']));
        $I->dontSeeInTitle('Control panel');
        $I->seeInTitle('Login');
    }

    /**
     * @before loginAsAdmin
     */
    public function testHomePage(AcceptanceTester $I)
    {
        $I->wantTo('ensure that admin home page works');
        $I->amOnPage(Url::to(['/admin/default/index']));
        $I->seeInTitle('Control panel');
    }
}