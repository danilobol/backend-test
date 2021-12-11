<?php

namespace App\Services\Contracts;

interface IUserRoleService {
    public function getAllUsersRole();
    public function createUserRole(string $userId, int $roleId, string $created_by);
    public function removeUserRole(string $userId, int $roleId);
}
