<?php

namespace tests\codeception\functional\user\profile;

use app\modules\user\models\User;
use FunctionalTester;
use tests\codeception\_pages\user\profile\UpdatePage;
use tests\codeception\functional\FunctionalCest;

class ProfileUpdateCest extends FunctionalCest
{
    public function _after()
    {
        User::findOne(['username' => 'admin'])->updateAttributes([
            'email' => 'admin@example.com',
        ]);
    }

    /**
     * @after logout
     */
    public function testProfileUpdate(FunctionalTester $I)
    {
        $I->wantTo('ensure that profile update form works');

        $this->login($I, 'admin', 'adminpass');

        $requestPage = UpdatePage::openBy($I);

        $I->seeInTitle('Update');

        $I->amGoingTo('try to request with empty credentials');
        $requestPage->send([
            'email' => '',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.', '.help-block');

        $I->amGoingTo('try to request with wrong credentials');
        $requestPage->send([
            'email' => 'wrong-email',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Email is not a valid email address.', '.help-block');

        $I->amGoingTo('try to request with correct credentials');
        $requestPage->send([
            'email' => 'correct@email.com',
        ]);
        $I->expectTo('see user info');
        $I->seeInTitle('Profile');
        $I->see('correct@email.com', '.detail-view');
    }
}
