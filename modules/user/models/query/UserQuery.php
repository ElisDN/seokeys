<?php

namespace app\modules\user\models\query;

use app\modules\user\models\User;
use yii\db\ActiveQuery;
use Yii;

class UserQuery extends ActiveQuery
{
    public function overdue()
    {
        return $this
            ->andWhere(['status' => User::STATUS_WAIT])
            ->andWhere(['<', 'created_at', time() - Yii::$app->params['user.emailConfirmTokenExpire']]);
    }
}