<?php

namespace tests\unit\models;

use app\modules\user\forms\frontend\SignupForm;
use Codeception\Test\Unit;
use tests\_fixtures\UserFixture;

class SignupFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/_fixtures/data/user.php'
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm('user', [
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'verifyCode' => 'testme',
        ]);

        $user = $model->signup();

        expect($user)->isInstanceOf('app\modules\user\models\User');

        expect($user->username)->equals('some_username');
        expect($user->email)->equals('some_email@example.com');
        expect($user->validatePassword('some_password'))->true();
    }

    public function testNotCorrectSignup()
    {
        $fixture = $this->tester->grabFixture('user', 0);

        $model = new SignupForm('user', [
            'username' => $fixture['username'],
            'email' => $fixture['email'],
            'password' => 'some_password',
            'verifyCode' => 'testme',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));

        expect($model->getFirstError('username'))
            ->equals('This username already exists.');
        expect($model->getFirstError('email'))
            ->equals('This Email already exists.');
    }
}
