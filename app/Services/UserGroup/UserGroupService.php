<?php

namespace App\Services\UserGroup;

use App\Repositories\Contracts\IUserGroupRepository;
use App\Services\Contracts\IUserGroupService;


class UserGroupService implements IUserGroupService
{

    protected $userGroupRepository;

    public function __construct(
        IUserGroupRepository $userGroupRepository,
    )
    {
        $this->userGroupRepository = $userGroupRepository;
    }

    public function addUserToGroup(int $userId, int $groupId, string $type){
        return $this->userGroupRepository->addUserToGroup($userId, $groupId, $type);
    }
    public function removeUserToGroup(int $userId, int $groupId):void{
        $this->userGroupRepository->removeUserToGroup($userId, $groupId);
    }
    public function getGroupsOfUser(int $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->userGroupRepository->getGroupsOfUser($userId);
    }
}
