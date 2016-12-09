<?php

namespace tests\unit\models;

use app\modules\user\forms\frontend\PasswordResetForm;
use Codeception\Test\Unit;
use tests\_fixtures\UserFixture;

class PasswordResetFormTest extends Unit
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
                'dataFile' => '@tests/unit/_fixtures/data/user-password-reset.php'
            ],
        ]);
    }

    public function testResetWrongToken()
    {
        $this->tester->expectException('yii\base\InvalidParamException', function() {
            new PasswordResetForm('', 3600);
        });

        $this->tester->expectException('yii\base\InvalidParamException', function() {
            new PasswordResetForm('notexistingtoken_1391882543', 3600);
        });
    }

    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new PasswordResetForm($user['password_reset_token'], 3600);
        expect_that($form->resetPassword());
    }
}
