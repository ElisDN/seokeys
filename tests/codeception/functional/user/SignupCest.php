<?php

namespace tests\codeception\functional\user;

use app\modules\user\models\User;
use FunctionalTester;
use tests\codeception\_pages\user\EmailConfirmPage;
use tests\codeception\_pages\user\SignupPage;
use tests\codeception\functional\FunctionalCest;

class SignupCest extends FunctionalCest
{
    public function _after()
    {
        User::deleteAll([
            'email' => 'tester.email@example.com',
            'username' => 'tester',
        ]);
    }

    public function testSignup(FunctionalTester $I)
    {
        $I->wantTo('ensure that signup works');

        $signupPage = SignupPage::openBy($I);

        $I->seeInTitle('Signup');
        $I->see('Please fill out the following fields to signup:');

        $I->amGoingTo('submit signup form with no data');
        $signupPage->submit([]);
        $I->expectTo('see validation errors');
        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->see('Password cannot be blank.', '.help-block');
        $I->see('The verification code is incorrect.', '.help-block');

        $I->amGoingTo('submit signup form with not correct data');
        $signupPage->submit([
            'username' => 'tester',
            'email' => 'tester.email',
            'password' => 'tester_password',
            'verifyCode' => 'wrong',
        ]);
        $I->expectTo('see that email address is wrong');
        $I->dontSee('Username cannot be blank.', '.help-block');
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
        $I->expectTo('see that user is created');
        $I->seeRecord(User::className(), [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'status' => User::STATUS_WAIT,
        ]);
        $I->expectTo('see that user signed in');
        $I->see('Please confirm your Email.', '.alert-success');

        $I->amGoingTo('confirm user email by token');
        /** @var User $user */
        $user = $I->grabRecord(User::className(), ['username' => 'tester']);
        EmailConfirmPage::openBy($I, ['token' => $user->email_confirm_token]);
        $I->expectTo('see that email is confirmed');
        $I->see('Thanks! Your Email is confirmed.', '.alert-success');
        $I->expectTo('see that user status is confirmed');
        $I->seeRecord(User::className(), [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'status' => User::STATUS_ACTIVE,
            'email_confirm_token' => null,
        ]);
    }
}
