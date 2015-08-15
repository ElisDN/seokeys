<?php

namespace tests\codeception\acceptance\main;

use AcceptanceTester;
use tests\codeception\acceptance\AcceptanceCest;

class HomeCest extends AcceptanceCest
{
    public function test(AcceptanceTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('SeoKeys');
    }
}

