<?php

namespace tests\unit\modules\user\backend\models;

use app\modules\user\models\backend\User;
use Codeception\Test\Unit;
use tests\_fixtures\UserFixture;

/**
 * @property array $users
 */
class UserTest extends Unit
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

    public function testValidateEmptyNewPassword()
    {
        $model = new User([
            'username' => 'TestName',
            'email' => 'other-email@example.com',
            'newPassword' => '',
            'newPasswordRepeat' => '',
            'status' => 1,
        ]);

        $model->scenario = User::SCENARIO_ADMIN_CREATE;

        expect('model is not valid', $model->validate())->false();
        expect('new password is required', $model->errors)->hasKey('newPassword');

        $model->scenario = User::SCENARIO_ADMIN_UPDATE;

        expect('model is valid', $model->validate())->true();
    }

    public function testValidateWrongNewPassword()
    {
        $model = new User([
            'username' => 'TestName',
            'email' => 'other@example.com',
            'newPassword' => 'short',
            'newPasswordRepeat' => '',
            'status' => 1,
        ]);

        $model->scenario = User::SCENARIO_ADMIN_CREATE;

        expect('model is not valid', $model->validate())->false();
        expect('password is too short', $model->errors)->hasKey('newPassword');
        expect('password repeat is required', $model->errors)->hasKey('newPasswordRepeat');

        $model = new User([
            'username' => 'TestName',
            'email' => 'other-email@example.com',
            'newPassword' => 'correct-password',
            'newPasswordRepeat' => 'qwerty',
            'status' => 1,
        ]);

        $model->scenario = User::SCENARIO_ADMIN_CREATE;

        expect('model is not valid', $model->validate())->false();
        expect('new password is correct', $model->errors)->hasntKey('newPassword');
        expect('password repeat is incorrect', $model->errors)->hasKey('newPasswordRepeat');
    }

    public function testValidateCorrectNewPassword()
    {
        $model = new User([
            'username' => 'TestName',
            'email' => 'other-email@example.com',
            'newPassword' => 'correct-password',
            'newPasswordRepeat' => 'correct-password',
            'status' => 1,
        ]);

        expect('model is valid', $model->validate())->true();
    }

    public function testSaveNewPassword()
    {
        $fixture = $this->tester->grabFixture('user', 0);

        /** @var User $model */
        $model = User::findOne($fixture['id']);

        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        $model->newPassword = 'new-password';
        $model->newPasswordRepeat = 'new-password';

        expect('model is saved', $model->save())->true();
        expect('password is correct', $model->validatePassword('new-password'))->true();
    }

    /**
     * @param string $scenario
     * @param array $expected
     * @dataProvider getScenarioAttributes
     *
     */
    public function testScenarios($scenario, $expected)
    {
        $model = new User(['scenario' => $scenario]);

        $actual = $model->safeAttributes();

        sort($expected);
        sort($actual);

        expect('safe attributes are correct', $actual)->equals($expected);
    }

    public function getScenarioAttributes()
    {
        return [
            'adminCreate' => ['adminCreate', [
                'username',
                'email',
                'role',
                'status',
                'newPassword',
                'newPasswordRepeat',
            ]],
            'adminUpdate' => ['adminUpdate', [
                'username',
                'role',
                'email',
                'status',
                'newPassword',
                'newPasswordRepeat',
            ]],
        ];
    }
}
