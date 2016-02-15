<?php

namespace tests\codeception\functional\user\profile;

use app\modules\user\models\User;
use FunctionalTester;
use tests\codeception\_pages\user\profile\PasswordChangePage;
use tests\codeception\functional\FunctionalCest;

class PasswordChangeCest extends FunctionalCest
{
    public function _after()
    {
        User::findOne(['username' => 'admin'])->updateAttributes([
            'password_hash' => '$2y$13$D8areN6YSJh.fmR.Ww/sWOJ8EXRxNS9c7u7ubIrVozomTR8MY0PbO',
        ]);
    }

    /**
     * @after logout
     */
    public function testPasswordChange(FunctionalTester $I)
    {
        $I->wantTo('ensure that password change works');

        $this->login($I, 'admin', 'adminpass');

        $requestPage = PasswordChangePage::openBy($I);

        $I->seeInTitle('Change password');

        $I->amGoingTo('try to request with empty credentials');
        $requestPage->send([
            'currentPassword' => '',
            'newPassword' => '',
            'newPasswordRepeat' => '',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Current Password cannot be blank.');
        $I->see('New Password cannot be blank.');

        $I->amGoingTo('try to request with wrong credentials');
        $requestPage->send([
            'currentPassword' => 'wrong-password',
            'newPassword' => 'sda',
            'newPasswordRepeat' => 'asd',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Wrong current password.');
        $I->see('New password should contain at least 6 characters.');
        $I->see('Repeat new password must be equal');

        $I->amGoingTo('try to request with correct credentials');
        $requestPage->send([
            'currentPassword' => 'adminpass',
            'newPassword' => 'new-password',
            'newPasswordRepeat' => 'new-password',
        ]);
        $I->expectTo('see user info');
        $I->see('Your passwords is changed.', '.alert-success');
    }
}
