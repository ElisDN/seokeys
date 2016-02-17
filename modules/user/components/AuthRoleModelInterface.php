<?php

namespace app\modules\user\components;

interface AuthRoleModelInterface
{
    /**
     * @param mixed $id
     * @return AuthRoleModelInterface
     */
    public static function findAuthRoleIdentity($id);

    /**
     * @param string $roleName
     * @return array
     */
    public static function findAuthIdsByRoleName($roleName);

    /**
     * @return array
     */
    public function getAuthRoleNames();

    /**
     * @param string $roleName
     */
    public function addAuthRoleName($roleName);

    /**
     * @param string $roleName
     */
    public function removeAuthRoleName($roleName);

    /**
     * Removes all roles
     */
    public function clearAuthRoleNames();
}