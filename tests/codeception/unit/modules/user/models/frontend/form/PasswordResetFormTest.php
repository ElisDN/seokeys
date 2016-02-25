<?php

namespace tests\codeception\unit\modules\user\models\frontend\form;

use app\modules\user\models\frontend\form\PasswordResetForm;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use yii\codeception\DbTestCase;

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
        new PasswordResetForm('notexistingtoken_1391882543', 3600);
    }

    /**
     * @expectedException \yii\base\InvalidParamException
     */
    public function testResetEmptyToken()
    {
        new PasswordResetForm('', 3600);
    }

    public function testResetCorrectToken()
    {
        $form = new PasswordResetForm($this->users[0]['password_reset_token'], 3600);
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
