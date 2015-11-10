<?php

namespace tests\codeception\unit\modules\user\models\form;

use yii\codeception\DbTestCase;
use tests\codeception\fixtures\UserFixture;
use app\modules\user\models\form\PasswordResetForm;
use Codeception\Specify;

/**
 * @property array $users
 */
class PasswordResetFormTest extends DbTestCase
{
    use Specify;

    /**
     * @expectedException \yii\base\InvalidParamException
     */
    public function testResetWrongToken()
    {
        new PasswordResetForm('notexistingtoken_1391882543');
    }

    /**
     * @expectedException \yii\base\InvalidParamException
     */
    public function testResetEmptyToken()
    {
        new PasswordResetForm('');
    }

    public function testResetCorrectToken()
    {
        $form = new PasswordResetForm($this->users[0]['password_reset_token']);
        expect('password should be resetted', $form->resetPassword())->true();
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
