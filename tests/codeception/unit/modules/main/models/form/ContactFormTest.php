<?php

namespace tests\codeception\unit\modules\main\models\form;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use yii\swiftmailer\Mailer;

class ContactFormTest extends TestCase
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
        unlink($this->getMessageFile());
        parent::tearDown();
    }

    public function testContact()
    {
        $model = $this->getMock('app\modules\main\models\form\ContactForm', ['validate']);
        $model->expects($this->once())->method('validate')->will($this->returnValue(true));

        /** @var \app\modules\main\models\form\ContactForm $model */
        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        $model->contact('admin@example.com');

        expect('email file should exist', file_exists($this->getMessageFile()))->true();

        $emailMessage = str_replace("=\r\n", '', file_get_contents($this->getMessageFile()));
        expect('email should contain user name', $emailMessage)->contains($model->name);
        expect('email should contain sender email', $emailMessage)->contains($model->email);
        expect('email should contain subject', $emailMessage)->contains($model->subject);
        expect('email should contain body', $emailMessage)->contains($model->body);
    }

    private function getMessageFile()
    {
        /** @var Mailer $mailer */
        $mailer = Yii::$app->mailer;
        return Yii::getAlias($mailer->fileTransportPath) . '/testing_message.eml';
    }
}
