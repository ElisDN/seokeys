<?php

namespace tests\functional;

use app\modules\user\models\User;
use FunctionalTester;
use tests\_fixtures\UserFixture;

class SignupCest
{
    private $formId = '#signup-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amOnRoute('user/default/signup');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Signup');
        $I->seeElement($this->formId);
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm($this->formId, []);
        $I->see('Username cannot be blank.', '.help-block');
        $I->see('Email cannot be blank.', '.help-block');
        $I->see('Password cannot be blank.', '.help-block');
    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'email',
            'SignupForm[password]'  => 'tester_password',
            'SignupForm[verifyCode]'  => 'testme',
        ]);
        $I->dontSee('Username cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->see('Email is not a valid email address.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'tester',
            'SignupForm[email]' => 'tester.email@example.com',
            'SignupForm[password]' => 'tester_password',
            'SignupForm[verifyCode]'  => 'testme',
        ]);
        $I->see('Please confirm your Email.', '.alert-success');
        $I->seeEmailIsSent();

        $I->seeRecord(User::className(), [
            'username' => 'tester',
            'email' => 'tester.email@example.com',
            'status' => User::STATUS_WAIT,
        ]);
    }

    public function confirmSuccessfully(FunctionalTester $I)
    {
        $user = $I->grabRecord(User::className(), ['username' => 'email-confirm']);

        $I->amOnRoute('user/default/email-confirm', ['token' => $user->email_confirm_token]);
        $I->see('Thanks! Your Email is confirmed.', '.alert-success');

        $I->seeRecord(User::className(), [
            'username' => $user->username,
            'status' => User::STATUS_ACTIVE
        ]);
    }

    public function confirmRepeat(FunctionalTester $I)
    {
        $user = $I->grabRecord(User::className(), ['username' => 'email-confirm']);

        $I->amOnRoute('user/default/email-confirm', ['token' => $user->email_confirm_token]);
        $I->see('Thanks! Your Email is confirmed.', '.alert-success');
        $I->amOnRoute('user/default/email-confirm', ['token' => $user->email_confirm_token]);
        $I->see('Wrong Email confirm token.');
    }

    public function confirmEmailWithWrongToken(FunctionalTester $I)
    {
        $I->amOnRoute('user/default/email-confirm', ['token' => 'wrong-token']);
        $I->see('Wrong Email confirm token.');
    }
}
