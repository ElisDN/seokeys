<?php

namespace app\modules\user\components\events;

use yii\base\Event;

class RemoveRoleEvent extends Event
{
    public $roleName;
}