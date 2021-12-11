<?php

namespace App\Services\Contracts;

interface IUserRoleService {
    public function getAllUsersRole();
    public function createUserRole(int $userId, int $roleId, int $created_by);
    public function removeUserRole(int $userId, int $roleId);
}
