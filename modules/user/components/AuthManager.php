<?php

namespace app\modules\user\components;

use yii\base\InvalidParamException;
use yii\base\InvalidValueException;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;
use Yii;

class AuthManager extends PhpManager
{
    /**
     * @var string User model class name
     * must be instance of AuthRoleModelInterface
     */
    public $modelClass = 'app\models\User';

    /**
     * @inheritdoc
     */
    public function getAssignments($userId)
    {
        $assignments = [];
        if ($userId && $user = $this->getUser($userId)) {
            foreach ($user->getAuthRoleNames() as $roleName) {
                $assignment = new Assignment();
                $assignment->userId = $userId;
                $assignment->roleName = $roleName;
                $assignments[$assignment->roleName] = $assignment;
            }
        }
        return $assignments;
    }

    /**
     * @inheritdoc
     */
    public function getAssignment($roleName, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if (in_array($roleName, $user->getAuthRoleNames())) {
                $assignment = new Assignment();
                $assignment->userId = $userId;
                $assignment->roleName = $roleName;
                return $assignment;
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getUserIdsByRole($roleName)
    {
        /** @var AuthRoleModelInterface $class */
        $class = $this->modelClass;
        return $class::findAuthIdsByRoleName($roleName);
    }

    /**
     * @inheritdoc
     */
    protected function updateItem($name, $item)
    {
        if (parent::updateItem($name, $item)) {
            if ($item->name !== $name) {
                /** @var AuthRoleModelInterface $class */
                $class = $this->modelClass;
                $class::updateAuthGlobalRoleName($name, $item->name);
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function removeItem($item)
    {
        if (parent::removeItem($item)) {
            /** @var AuthRoleModelInterface $class */
            $class = $this->modelClass;
            $class::removeAuthGlobalRoleName($item->name);
            return true;
        }
        return false;
    }

    public function removeAll()
    {
        parent::removeAll();
        /** @var AuthRoleModelInterface $class */
        $class = $this->modelClass;
        $class::removeAuthGlobalRoleNames();
    }

    public function removeAllAssignments()
    {
        parent::removeAllAssignments();
        /** @var AuthRoleModelInterface $class */
        $class = $this->modelClass;
        $class::removeAuthGlobalAssignments();
    }

    /**
     * @inheritdoc
     */
    public function assign($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if (in_array($role->name, $user->getAuthRoleNames())) {
                throw new InvalidParamException("Authorization item '{$role->name}' has already been assigned to user '$userId'.");
            } else {
                $assignment = new Assignment([
                    'userId' => $userId,
                    'roleName' => $role->name,
                    'createdAt' => time(),
                ]);
                $user->addAuthRoleName($role->name);
                return $assignment;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function revoke($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if (in_array($role->name, $user->getAuthRoleNames())) {
                $user->removeAuthRoleName($role->name);
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function revokeAll($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $user->clearAuthRoleNames();
            return true;
        }
        return false;
    }

    /**
     * @param integer $userId
     * @return null|AuthRoleModelInterface
     */
    private function getUser($userId)
    {
        /** @var \yii\web\User $webUser */
        $webUser = Yii::$app->get('user', false);
        if ($webUser && !$webUser->getIsGuest() && $webUser->getId() == $userId && $webUser->getIdentity() instanceof AuthRoleModelInterface) {
            return $webUser->getIdentity();
        } else {
            /** @var AuthRoleModelInterface $class */
            $class = $this->modelClass;
            $identity = $class::findAuthRoleIdentity($userId);
            if ($identity && !$identity instanceof AuthRoleModelInterface) {
                throw new InvalidValueException('The identity object must implement AuthRoleInterface.');
            }
            return $identity;
        }
    }
} 