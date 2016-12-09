<?php

namespace tests\acceptance\main;

use AcceptanceTester;

class HomeCest
{
    public function test(AcceptanceTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('SeoKeys');
    }
}

