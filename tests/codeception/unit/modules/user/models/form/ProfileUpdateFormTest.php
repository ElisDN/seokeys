<?php

namespace tests\codeception\unit\modules\user\models\form;

use app\modules\user\models\User;
use app\modules\user\models\form\ProfileUpdateForm;
use yii\codeception\DbTestCase;
use tests\codeception\fixtures\UserFixture;
use Codeception\Specify;

/**
 * @property array $users
 */
class ProfileUpdateFormTest extends DbTestCase
{
    use Specify;

    public function testUpdateNotCorrect()
    {
        /** @var User $user */
        $user = User::findOne($this->users[0]['id']);

        $form = new ProfileUpdateForm($user);

        $form->email = '';

        expect('form is not valid', $form->update())->false();
        expect('email is required', $form->errors)->hasKey('email');

        $form->email = 'wrong-email';

        expect('form is not valid', $form->update())->false();
        expect('email is incorrect', $form->errors)->hasKey('email');

        $form->email = 'reset@example.com';

        expect('form is not valid', $form->update())->false();
        expect('email exists', $form->errors)->hasKey('email');
    }

    public function testUpdateCorrect()
    {
        /** @var User $user */
        $user = User::findOne($this->users[0]['id']);

        $form = new ProfileUpdateForm($user);

        $form->setAttributes([
            'email' => 'new-email@site.com',
        ]);

        expect('user is updated', $form->update())->true();
        expect('email is new', $user->email)->equals('new-email@site.com');
    }

    public function fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::className(),
            ],
        ];
    }
}
