<?php

namespace tests\codeception\unit\modules\user\models\frontend\form;

use app\modules\user\models\frontend\form\PasswordChangeForm;
use app\modules\user\models\User;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use yii\codeception\DbTestCase;

/**
 * @property array $users
 */
class PasswordChangeFormTest extends DbTestCase
{
    use Specify;

    public function testChangeNotCorrect()
    {
        /** @var User $user */
        $user = User::findOne($this->users[0]['id']);

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
        /** @var User $user */
        $user = User::findOne($this->users[0]['id']);

        $form = new PasswordChangeForm($user);

        $form->setAttributes([
            'currentPassword' => 'adminpass',
            'newPassword' => 'new-password',
            'newPasswordRepeat' => 'new-password',
        ]);

        expect('password is changed', $form->changePassword())->true();
        expect('password is correct', $user->validatePassword('new-password'))->true();
    }

    public function fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/unit/fixtures/data/user-password-reset.php',
            ],
        ];
    }
}
