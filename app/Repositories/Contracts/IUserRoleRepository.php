<?php

namespace App\Repositories\Contracts;

interface IUserRoleRepository {
    public function getAllUsersRole();
    public function createUserRole(int $userId, int $roleId, int $created_by);
    public function removeUserRole(int $id_user, int $id_role);
}
