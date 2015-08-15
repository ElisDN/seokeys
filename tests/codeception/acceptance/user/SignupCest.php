<?php

namespace tests\codeception\acceptance\user;

use AcceptanceTester;
use app\modules\user\models\User;
use tests\codeception\_pages\user\EmailConfirmPage;
use tests\codeception\_pages\user\PasswordResetPage;
use tests\codeception\_pages\user\PasswordResetRequestPage;
use tests\codeception\_pages\user\SignupPage;
use tests\codeception\acceptance\AcceptanceCest;

class SignupCest extends AcceptanceCest
{
    public function _after()
    {
        User::deleteAll([
            'email' => 'tester.email@example.com',
            'username' => 'tester',
        ]);
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function testSignup($I)
    {
        $I->wantTo('ensure that signup works');
        $signupPage = SignupPage::openBy($I);
        $I->seeInTitle('Signup');
        $I->see('Please fill out the following fields to signup:');

        $I->amGoingTo('submit signup form with no data');
        $signupPage->submit([]);
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see validation errors');
        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->see('Password cannot be blank.', '.help-block');

        $I->amGoingTo('submit signup form with not correct data');
        $signupPage->submit([
            'username' => 'tester',
            'email' => 'tester.email',
            'password' => 'tester_password',
            'verifyCode' => 'wrong',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see that email address is wrong');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->see('Email is not a valid email address.', '.help-block');
        $I->see('The verification code is incorrect.', '.help-block');

        $I->amGoingTo('submit signup form with correct data');
        $signupPage->submit([
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'password' => 'tester_password',
            'verifyCode' => 'testme',
        ]);
        if (method_exists($I, 'wait')) {
            $I->wait(3); // only for selenium
        }
        $I->expectTo('see that user signed in');
        $I->see('Please confirm your Email.');

        $I->amGoingTo('confirm user email by token');
        /** @var \app\modules\user\models\User $user */
        $user = User::findOne(['username' => 'tester']);
        EmailConfirmPage::openBy($I, ['token' => $user->email_confirm_token]);
        $I->expectTo('see that email is confirmed');
        $I->see('Thanks! Your Email is confirmed.', '.alert-success');
        EmailConfirmPage::openBy($I, ['token' => $user->email_confirm_token]);
        $I->expectTo('see that token is incorrect');
        $I->see('Wrong Email confirm token.');
    }

    public function testPasswordReset(AcceptanceTester $I)
    {
        $I->wantTo('ensure that login works');

        $requestPage = PasswordResetRequestPage::openBy($I);

        $I->seeInTitle('Reset password');

        $I->amGoingTo('try to request with empty credentials');
        $requestPage->send('');
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.');

        $I->amGoingTo('try to request with wrong credentials');
        $requestPage->send('reset-example.com');
        if (method_exists($I, 'wait')) {
            $I->wait(1); // only for selenium
        }
        $I->expectTo('see validations errors');
        $I->see('Email is not a valid email address.');

        $I->amGoingTo('try to request with correct credentials');
        $requestPage->send('reset@example.com');
        if (method_exists($I, 'wait')) {
            $I->wait(2); // only for selenium
        }
        $I->expectTo('see user info');
        $I->see('Follow the link on mail to reset your password.', '.alert-success');

        $I->amGoingTo('open change password page by token');
        /** @var User $user */
        $user = User::findOne(['email' => 'reset@example.com']);
        $resetPage = PasswordResetPage::openBy($I, ['token' => $user->password_reset_token]);
        $I->expectTo('see change password form');
        $I->see('Please choose your new password:');

        $I->amGoingTo('set new password');
        $resetPage->send('new-password');
        if (method_exists($I, 'wait')) {
            $I->wait(2); // only for selenium
        }
        $I->expectTo('see password change success message');
        $I->see('Thanks! Your passwords is changed.');

        $I->amGoingTo('try to login with new credentials');
        $this->login($I, 'reset', 'new-password');
        $I->expectTo('see user info');
        $I->see('Profile');
    }
}