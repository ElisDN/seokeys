<?php

namespace tests\unit\modules\user\forms\frontend;

use app\modules\user\forms\frontend\ProfileUpdateForm;
use app\modules\user\models\User;
use Codeception\Test\Unit;
use tests\_fixtures\UserFixture;

class ProfileUpdateFormTest extends Unit
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

    public function testUpdateNotCorrect()
    {
        $fixture = $this->tester->grabFixture('user', 0);

        /** @var User $user */
        $user = User::findOne($fixture['id']);

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
        $fixture = $this->tester->grabFixture('user', 0);

        /** @var User $user */
        $user = User::findOne($fixture['id']);

        $form = new ProfileUpdateForm($user);

        $form->setAttributes([
            'email' => 'new-email@site.com',
        ]);

        expect('user is updated', $form->update())->true();
        expect('email is new', $user->email)->equals('new-email@site.com');
    }
}
