<?php

namespace tests\functional\user\profile;

use FunctionalTester;
use tests\_fixtures\UserFixture;

class ProfileUpdateCest
{
    private $formId = '#profile-update-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amLoggedInAsUser();
        $I->amOnRoute('user/profile/update');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Update');
        $I->seeElement($this->formId);
    }

    public function updateWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'ProfileUpdateForm[email]' => '',
        ]);

        $I->see('Email cannot be blank.', '.help-block');
    }

    public function updateWithWrongFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'ProfileUpdateForm[email]' => 'wrong-email',
        ]);

        $I->see('Email is not a valid email address.', '.help-block');
    }

    public function updateSuccess(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'ProfileUpdateForm[email]' => 'correct@email.com',
        ]);

        $I->seeInTitle('Profile');
        $I->see('correct@email.com', '.detail-view');
    }
}
