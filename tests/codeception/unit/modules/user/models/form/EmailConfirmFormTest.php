<?php

namespace tests\codeception\unit\modules\user\models\form;

use yii\codeception\DbTestCase;
use tests\codeception\fixtures\UserFixture;
use app\modules\user\models\form\EmailConfirmForm;
use Codeception\Specify;

/**
 * @property array $users
 */
class EmailConfirmFormTest extends DbTestCase
{
    use Specify;

    /**
     * @expectedException \yii\base\InvalidParamException
     */
    public function testConfirmWrongToken()
    {
        new EmailConfirmForm('notexistingtoken_1391882543');
    }

    /**
     * @expectedException \yii\base\InvalidParamException
     */
    public function testConfirmEmptyToken()
    {
        new EmailConfirmForm('');
    }

    public function testConfirmCorrectToken()
    {
        $form = new EmailConfirmForm($this->users[0]['email_confirm_token']);
        expect('email should be confirmed', $form->confirmEmail())->true();
    }

    public function fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/unit/fixtures/data/user-email-confirm.php',
            ],
        ];
    }
}
