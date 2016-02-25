<?php

namespace tests\codeception\unit\modules\user\backend\models;

use app\modules\user\models\backend\User;
use Codeception\Specify;
use tests\codeception\fixtures\UserFixture;
use yii\codeception\DbTestCase;

/**
 * @property array $users
 */
class UserTest extends DbTestCase
{
    use Specify;

    public function testValidateEmptyNewPassword()
    {
        $model = new User([
            'username' => 'TestName',
            'email' => 'other@example.com',
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
            'email' => 'other@example.com',
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
            'email' => 'other@example.com',
            'newPassword' => 'correct-password',
            'newPasswordRepeat' => 'correct-password',
            'status' => 1,
        ]);

        expect('model is valid', $model->validate())->true();
    }

    public function testSaveNewPassword()
    {
        /** @var User $model */
        $model = User::findOne($this->users[0]['id']);

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
                'status',
                'newPassword',
                'newPasswordRepeat',
            ]],
            'adminUpdate' => ['adminUpdate', [
                'username',
                'email',
                'status',
                'newPassword',
                'newPasswordRepeat',
            ]],
        ];
    }

    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
        ];
    }
}
