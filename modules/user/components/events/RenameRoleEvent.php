<?php

namespace app\modules\user\components\events;

use yii\base\Event;

class RenameRoleEvent extends Event
{
    public $oldRoleName;
    public $newRoleName;
}