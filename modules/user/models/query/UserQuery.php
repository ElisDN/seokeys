<?php

namespace app\modules\user\models\query;

use app\modules\user\models\User;
use yii\db\ActiveQuery;
use Yii;

class UserQuery extends ActiveQuery
{
    private $_timeout;

    /**
     * @inheritdoc
     * @param integer $timeout
     */
    public function __construct($modelClass, $timeout, $config = [])
    {
        $this->_timeout = $timeout;
        parent::__construct($modelClass, $config);
    }

    /**
     * @return $this
     */
    public function overdue()
    {
        return $this
            ->andWhere(['status' => User::STATUS_WAIT])
            ->andWhere(['<', 'created_at', time() - $this->_timeout]);
    }
}