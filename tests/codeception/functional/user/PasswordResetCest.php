<?php

namespace tests\codeception\functional\user;

use app\modules\user\models\User;
use FunctionalTester;
use tests\codeception\_pages\user\PasswordResetPage;
use tests\codeception\_pages\user\PasswordResetRequestPage;
use tests\codeception\functional\FunctionalCest;

class PasswordResetCest extends FunctionalCest
{
    /**
     * @after logout
     */
    public function testPasswordReset(FunctionalTester $I)
    {
        $I->wantTo('ensure that login works');

        $requestPage = PasswordResetRequestPage::openBy($I);

        $I->seeInTitle('Reset password');

        $I->amGoingTo('try to request with empty credentials');
        $requestPage->send('');
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.');

        $I->amGoingTo('try to request with wrong credentials');
        $requestPage->send('reset-example.com');
        $I->expectTo('see validations errors');
        $I->see('Email is not a valid email address.');

        $I->amGoingTo('try to request with correct credentials');
        $requestPage->send('reset@example.com');
        $I->expectTo('see user info');
        $I->see('Follow the link on mail to reset your password.', '.alert-success');

        $I->amGoingTo('open change password page by token');
        /** @var User $user */
        $user = $I->grabRecord(User::className(), ['email' => 'reset@example.com']);
        $resetPage = PasswordResetPage::openBy($I, ['token' => $user->password_reset_token]);
        $I->expectTo('see change password form');
        $I->see('Please choose your new password:');

        $I->amGoingTo('set new password');
        $resetPage->send('new-password');
        $I->expectTo('see password change success message');
        $I->see('Thanks! Your passwords is changed.');

        $I->amGoingTo('try to login with new credentials');
        $this->login($I, 'reset', 'new-password');
        $I->expectTo('see user info');
        $I->see('Profile');
    }
}
