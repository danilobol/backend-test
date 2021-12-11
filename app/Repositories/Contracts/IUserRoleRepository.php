<?php

namespace App\Repositories\Contracts;

interface IUserRoleRepository {
    public function getAllUsersRole();
    public function createUserRole(string $userId, int $roleId, string $created_by);
    public function removeUserRole(string $id_user, int $id_role);
}
