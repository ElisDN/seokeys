<?php

namespace tests\codeception\unit\modules\user\models\frontend\form;

use app\modules\user\models\frontend\form\PasswordResetRequestForm;
use app\modules\user\models\User;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use Yii;
use yii\codeception\DbTestCase;
use yii\swiftmailer\Mailer;

/**
 * @property array $users
 */
class PasswordResetRequestFormTest extends DbTestCase
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

    protected function tearDown()
    {
        @unlink($this->getMessageFile());

        parent::tearDown();
    }

    public function testSendEmailWrongUser()
    {
        $model = new PasswordResetRequestForm(3600);
        $model->email = 'not-existing-email@example.com';

        expect('not existing user email not sent', $model->sendEmail())->false();

        $model = new PasswordResetRequestForm(3600);
        $model->email = $this->users[1]['email'];

        expect('active user email not sent', $model->sendEmail())->false();
    }

    public function testSendEmailCorrectUser()
    {
        $model = new PasswordResetRequestForm(3600);
        $model->email = $this->users[0]['email'];
        /** @var User $user */
        $user = User::findOne(['password_reset_token' => $this->users[0]['password_reset_token']]);

        expect('email sent', $model->sendEmail())->true();
        expect('user has valid token', $user->password_reset_token)->notNull();

        expect('message file exists', file_exists($this->getMessageFile()))->true();

        $message = file_get_contents($this->getMessageFile());
        expect('message file "from" is correct', $message)->contains(Yii::$app->params['supportEmail']);
        expect('message file "to" is correct', $message)->contains($model->email);
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

    private function getMessageFile()
    {
        /** @var Mailer $mailer */
        $mailer = Yii::$app->mailer;
        return Yii::getAlias($mailer->fileTransportPath) . '/testing_message.eml';
    }
}
