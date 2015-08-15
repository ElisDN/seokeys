<?php

namespace tests\codeception\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\user\models\User';
    public $dataFile = '@tests/codeception/fixtures/data/user.php';
}
