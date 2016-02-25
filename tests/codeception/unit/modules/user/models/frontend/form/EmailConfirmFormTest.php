<?php

namespace tests\codeception\unit\modules\user\models\frontend\form;

use app\modules\user\models\frontend\form\EmailConfirmForm;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use yii\codeception\DbTestCase;

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
