<?php

namespace tests\functional\user;

use app\modules\user\models\User;
use FunctionalTester;
use tests\_fixtures\UserFixture;

class PasswordResetCest
{
    private $requestFormId = '#password-reset-request-form';
    private $resetFormId = '#password-reset-form';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
        $I->amOnRoute('user/default/password-reset-request');
    }

    public function open(FunctionalTester $I)
    {
        $I->seeInTitle('Reset password');
        $I->seeElement($this->requestFormId);
    }

    public function requestWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm($this->requestFormId, [
            'PasswordResetRequestForm[email]' => '',
        ]);
        $I->see('Email cannot be blank.');
    }

    public function requestWithWrongFields(FunctionalTester $I)
    {
        $I->submitForm($this->requestFormId, [
            'PasswordResetRequestForm[email]' => 'reset-example.com',
        ]);
        $I->see('Email is not a valid email address.');
    }

    public function requestSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->requestFormId, [
            'PasswordResetRequestForm[email]' => 'reset@example.com',
        ]);
        $I->seeEmailIsSent();
        $I->see('Follow the link on mail to reset your password.', '.alert-success');
    }

    public function resetWithWrongToken(FunctionalTester $I)
    {
        $I->amOnRoute('user/default/password-reset', ['token' => 'wrong-token']);

        $I->see('Wrong password reset token.');
    }

    public function resetSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->requestFormId, [
            'PasswordResetRequestForm[email]' => 'reset@example.com',
        ]);

        /** @var User $user */
        $user = $I->grabRecord(User::className(), ['email' => 'reset@example.com']);

        $I->amOnRoute('user/default/password-reset', ['token' => $user->password_reset_token]);

        $I->see('Please choose your new password:');

        $I->submitForm($this->resetFormId, [
            'PasswordResetForm[password]' => 'new-password',
        ]);

        $I->see('Thanks! Your passwords is changed.');
    }
}
