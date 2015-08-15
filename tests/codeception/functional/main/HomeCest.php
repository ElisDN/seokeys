<?php

namespace tests\codeception\functional\main;

use FunctionalTester;
use tests\codeception\functional\FunctionalCest;

class HomeCest extends FunctionalCest
{
    public function test(FunctionalTester $I)
    {
        $I->wantTo('ensure that home page works');
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('SeoKeys');
    }
}