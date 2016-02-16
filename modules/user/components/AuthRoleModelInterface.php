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
     * @param string $oldRoleName
     * @param string $newRoleName
     */
    public static function updateAuthGlobalRoleName($oldRoleName, $newRoleName);

    /**
     * @param string $roleName
     */
    public static function removeAuthGlobalRoleName($roleName);

    /**
     * On all roles removing
     */
    public static function removeAuthGlobalRoleNames();

    /**
     * On all assignments removing
     */
    public static function removeAuthGlobalAssignments();

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