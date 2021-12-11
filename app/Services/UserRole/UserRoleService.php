<?php
namespace App\Services\UserRole;

use App\Repositories\Contracts\IUserRoleRepository;
use App\Services\Contracts\IUserRoleService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserRoleService implements IUserRoleService{

    protected $userRoleRepository;

    function __construct(IUserRoleRepository $userRoleRepository)
    {
        $this->userRoleRepository = $userRoleRepository;
    }

    public function getAllUsersRole() {
        return $this->userRoleRepository->getAllUsersRole();
    }

    public function createUserRole(int $userId, int $roleId, int $created_by) {

        $validator = Validator::make(['user_id' => $userId, 'role_id' => $roleId], [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->userRoleRepository->createUserRole($userId, $roleId, $created_by);
    }


    public function removeUserRole(int $userId, int $roleId) {

        $validator = Validator::make(['user_id' => $userId, 'role_id' => $roleId], [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->userRoleRepository->removeUserRole($userId, $roleId);
    }
}
