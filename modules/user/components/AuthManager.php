<?php

namespace app\modules\user\components;

use app\modules\user\components\events\RemoveAllAssignmentsEvent;
use app\modules\user\components\events\RemoveAllEvent;
use app\modules\user\components\events\RemoveRoleEvent;
use app\modules\user\components\events\RenameRoleEvent;
use yii\base\InvalidParamException;
use yii\base\InvalidValueException;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;
use Yii;

class AuthManager extends PhpManager
{
    const EVENT_RENAME_ROLE = 'renameRole';
    const EVENT_REMOVE_ROLE = 'removeRole';
    const EVENT_REMOVE_ALL = 'removeAll';
    const EVENT_REMOVE_ALL_ASSIGNMENTS = 'removeAllAssignments';

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
                $this->trigger(self::EVENT_RENAME_ROLE, new RenameRoleEvent([
                    'oldRoleName' => $name,
                    'newRoleName' => $item->name,
                ]));
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
            $this->trigger(self::EVENT_REMOVE_ROLE, new RemoveRoleEvent([
                'roleName' => $item->name,
            ]));
            return true;
        }
        return false;
    }

    public function removeAll()
    {
        parent::removeAll();
        $this->trigger(self::EVENT_REMOVE_ALL, new RemoveAllEvent());
    }

    public function removeAllAssignments()
    {
        parent::removeAllAssignments();
        $this->trigger(self::EVENT_REMOVE_ALL_ASSIGNMENTS, new RemoveAllAssignmentsEvent());
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
     * @throws \yii\base\InvalidValueException
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