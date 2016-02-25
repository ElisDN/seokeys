<?php

namespace tests\codeception\unit\modules\user\models\frontend\form;

use app\modules\user\models\frontend\form\SignupForm;
use app\modules\user\models\User;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use Yii;
use yii\codeception\DbTestCase;
use yii\swiftmailer\Mailer;

class SignupFormTest extends DbTestCase
{
    use Specify;

    protected function setUp()
    {
        parent::setUp();
        /** @var Mailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->fileTransportCallback = function () {
            return 'testing_message.eml';
        };
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'verifyCode' => 'testme',
        ]);

        $user = $model->signup();

        $this->assertInstanceOf(User::className(), $user, 'user should be valid');

        expect('username should be correct', $user->username)->equals('some_username');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();

        expect('email file should exist', file_exists($this->getMessageFile()))->true();

        $emailMessage = str_replace("=\r\n", '', file_get_contents($this->getMessageFile()));
        expect('email should contain confirmation token', $emailMessage)->contains($user->email_confirm_token);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'some_password',
            'verifyCode' => 'testme',
        ]);

        expect('username and email are in use, user should not be created', $model->signup())->null();
    }

    private function getMessageFile()
    {
        /** @var Mailer $mailer */
        $mailer = Yii::$app->mailer;
        return Yii::getAlias($mailer->fileTransportPath) . '/testing_message.eml';
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
