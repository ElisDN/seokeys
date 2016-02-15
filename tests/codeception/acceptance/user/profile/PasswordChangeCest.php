<?php

namespace tests\codeception\acceptance\user\profile;

use AcceptanceTester;
use app\modules\user\models\User;
use tests\codeception\_pages\user\profile\PasswordChangePage;
use tests\codeception\acceptance\AcceptanceCest;

class PasswordChangeCest extends AcceptanceCest
{
    public function _after()
    {
        User::findOne(['username' => 'admin'])->updateAttributes([
            'password_hash' => '$2y$13$D8areN6YSJh.fmR.Ww/sWOJ8EXRxNS9c7u7ubIrVozomTR8MY0PbO',
        ]);
    }

    /**
     * @before loginAsAdmin
     */
    public function testPasswordChange(AcceptanceTester $I)
    {
        $I->wantTo('ensure that login works');

        $requestPage = PasswordChangePage::openBy($I);

        $I->seeInTitle('Change password');

        $I->amGoingTo('try to request with empty credentials');
        $requestPage->send([
            'currentPassword' => '',
            'newPassword' => '',
            'newPasswordRepeat' => '',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Current Password cannot be blank.');
        $I->see('New Password cannot be blank.');

        $I->amGoingTo('try to request with wrong new password');
        $requestPage->send([
            'currentPassword' => 'wrong-password',
            'newPassword' => 'sda',
            'newPasswordRepeat' => 'asd',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('New password should contain at least 6 characters.');
        $I->see('Repeat new password must be equal');

        $I->amGoingTo('try to request with wrong current password');
        $requestPage->send([
            'currentPassword' => 'wrong-password',
            'newPassword' => 'new-password',
            'newPasswordRepeat' => 'new-password',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Wrong current password.');

        $I->amGoingTo('try to request with correct credentials');
        $requestPage->send([
            'currentPassword' => 'adminpass',
            'newPassword' => 'new-password',
            'newPasswordRepeat' => 'new-password',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see user info');
        $I->see('Your passwords is changed.', '.alert-success');
    }
}
