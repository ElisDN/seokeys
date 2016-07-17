<?php

namespace app\modules\user\models\query;

use app\modules\user\models\User;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    private $timeout;

    public function __construct($className, $timeout)
    {
        parent::__construct($className);
        $this->timeout = $timeout;
    }

    public function overdue()
    {
        return $this
            ->andWhere(['status' => User::STATUS_WAIT])
            ->andWhere(['<', 'created_at', time() - $this->timeout]);
    }
}