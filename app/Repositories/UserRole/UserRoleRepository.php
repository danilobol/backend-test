<?php

namespace App\Repositories\UserRole;

use App\Models\UserRole;
use App\Repositories\Contracts\IUserRoleRepository;

class UserRoleRepository implements IUserRoleRepository {
    /**
     * @var UserRole
     */
    protected $userRole;

    const ALLOWED_FILTERS = [
        'id',
        'user_id',
        'role_id',
        'created_at',
        'updated_at',
    ];

    /**
     * UserRole Repository Constructor
     * @param UserRole $userRole
     */
    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;
    }

    /**
     * Get filtered user roles
     *
     * @return array
     */
    public function getAllUsersRole() {
        return $this->userRole::filtered(self::ALLOWED_FILTERS)->with('user')->with('role')->get();
    }

    public function createUserRole(int $userId, int $roleId, int $created_by) {
        return $this->userRole::create([
            'user_id'       => $userId,
            'role_id'       => $roleId,
            'created_by'    => $created_by,
            'updated_by'    => $created_by
        ]);
    }


    public function removeUserRole(int $id_user, int $id_role) {
        $userRole = $this->userRole::
        where('user_id', $id_user)
            ->where('role_id', $id_role)
            ->first();

        return $userRole->delete();
    }
}
