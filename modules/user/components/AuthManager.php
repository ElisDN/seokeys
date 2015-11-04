<?php

namespace app\modules\user\components;

use app\modules\user\models\User;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;
use Yii;

class AuthManager extends PhpManager
{
    public function getAssignments($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $assignment = new Assignment();
            $assignment->userId = $userId;
            $assignment->roleName = $user->role;
            return [$assignment->roleName => $assignment];
        }
        return [];
    }

    public function getAssignment($roleName, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role == $roleName) {
                $assignment = new Assignment();
                $assignment->userId = $userId;
                $assignment->roleName = $user->role;
                return $assignment;
            }
        }
        return null;
    }

    public function getUserIdsByRole($roleName)
    {
        return User::find()->andWhere(['role' => $roleName])->select('id')->column();
    }

    protected function updateItem($name, $item)
    {
        if (parent::updateItem($name, $item)) {
            if ($item->name !== $name) {
                User::updateAll(['role' => $name], ['role' => $item->name]);
            }
            return true;
        }
        return false;
    }

    public function removeItem($item)
    {
        if (parent::removeItem($item)) {
            User::updateAll(['role' => null], ['role' => $item->name]);
            return true;
        }
        return false;
    }

    public function removeAll()
    {
        parent::removeAll();
        User::updateAll(['role' => null]);
    }

    public function removeAllAssignments()
    {
        parent::removeAllAssignments();
        User::updateAll(['role' => null]);
    }

    public function assign($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $user->updateAttributes(['role' => $user->role = $role->name]);
            return true;
        }
        return false;
    }

    public function revoke($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role == $role->name) {
                $user->updateAttributes(['role' => $user->role = null]);
                return true;
            }
        }
        return false;
    }

    public function revokeAll($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $user->updateAttributes(['role' => $user->role = null]);
            return true;
        }
        return false;
    }

    /**
     * @param integer $userId
     * @return null|\yii\web\IdentityInterface|User
     */
    private function getUser($userId)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $userId) {
            return Yii::$app->user->identity;
        } else {
            return User::findOne($userId);
        }
    }
} 