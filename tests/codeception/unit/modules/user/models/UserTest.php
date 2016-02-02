<?php

namespace tests\codeception\unit\modules\user\models;

use app\modules\user\models\User;
use tests\codeception\fixtures\UserFixture;
use yii\codeception\DbTestCase;
use Codeception\Specify;

class UserTest extends DbTestCase
{
    use Specify;

    public function testValidateWrongData()
    {
        $model = new User([
            'username' => 'wrong%username',
            'email' => 'wrong%email',
            'status' => -1,
        ]);

        expect('model is not valid', $model->validate())->false();
        expect('username is incorrect', $model->errors)->hasKey('username');
        expect('email is incorrect', $model->errors)->hasKey('email');
        expect('status is incorrect', $model->errors)->hasKey('status');
    }

    public function testValidateExistingData()
    {
        $model = new User([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'status' => 1,
        ]);

        expect('model is not valid', $model->validate())->false();
        expect('username exists', $model->errors)->hasKey('username');
        expect('email exists', $model->errors)->hasKey('email');
    }

    public function testValidateCorrectData()
    {
        $model = new User([
            'username' => 'other_user',
            'email' => 'other@example.com',
            'status' => 1,
        ]);

        expect('model is valid', $model->validate())->true();
    }

    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
        ];
    }
}
