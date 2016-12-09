<?php

namespace tests\unit\modules\user\forms\frontend;

use app\modules\user\forms\frontend\PasswordChangeForm;
use app\modules\user\models\User;
use Codeception\Test\Unit;
use tests\_fixtures\UserFixture;

class PasswordChangeFormTest extends Unit
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
                'dataFile' => '@tests/unit/_fixtures/data/user-password-change.php'
            ]
        ]);
    }

    public function testChangeNotCorrect()
    {
        $fixture = $this->tester->grabFixture('user', 0);

        /** @var User $user */
        $user = User::findOne($fixture['id']);

        $form = new PasswordChangeForm($user);

        $form->setAttributes([
            'currentPassword' => '',
            'newPassword' => '',
            'newPasswordRepeat' => '',
        ]);

        expect('form is not valid', $form->changePassword())->false();
        expect('currentPassword is required', $form->errors)->hasKey('currentPassword');
        expect('newPassword is required', $form->errors)->hasKey('newPassword');
        expect('newPasswordRepeat is required', $form->errors)->hasKey('newPasswordRepeat');

        $form->setAttributes([
            'currentPassword' => 'wrong-password',
            'newPassword' => 'asd',
            'newPasswordRepeat' => 'sda',
        ]);

        expect('form is not valid', $form->changePassword())->false();
        expect('currentPassword is incorrect', $form->errors)->hasKey('currentPassword');
        expect('newPassword is incorrect', $form->errors)->hasKey('newPassword');
        expect('newPasswordRepeat is incorrect', $form->errors)->hasKey('newPasswordRepeat');
    }

    public function testChangeCorrect()
    {
        $fixture = $this->tester->grabFixture('user', 0);

        /** @var User $user */
        $user = User::findOne($fixture['id']);

        $form = new PasswordChangeForm($user);

        $form->setAttributes([
            'currentPassword' => 'adminpass',
            'newPassword' => 'new-password',
            'newPasswordRepeat' => 'new-password',
        ]);

        expect('password is changed', $form->changePassword())->true();
        expect('password is correct', $user->validatePassword('new-password'))->true();
    }
}
