<?php

namespace tests\functional\user\profile;

use FunctionalTester;
use tests\_fixtures\UserFixture;

class PasswordChangeCest
{
    private $formId = '#password-change-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amLoggedInAsAdmin();
        $I->amOnRoute('user/profile/password-change');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Change password');
        $I->seeElement($this->formId);
    }

    public function changeWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('', '', ''));
        $I->see('Current Password cannot be blank.');
        $I->see('New Password cannot be blank.');

    }

    public function changeWithWrongFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('wrong-password', 'sda', 'asd'));
        $I->see('Wrong current password.');
        $I->see('New password should contain at least 6 characters.');
        $I->see('Repeat new password must be equal');
    }

    public function changeSuccess(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('adminpass', 'new-password', 'new-password'));
        $I->see('Your passwords is changed.', '.alert-success');
    }

    private function formParams($currentPassword, $newPassword, $newPasswordRepeat)
    {
        return [
            'PasswordChangeForm[currentPassword]' => $currentPassword,
            'PasswordChangeForm[newPassword]' => $newPassword,
            'PasswordChangeForm[newPasswordRepeat]' => $newPasswordRepeat,
        ];
    }
}
