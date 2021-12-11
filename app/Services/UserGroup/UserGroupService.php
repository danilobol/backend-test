<?php

namespace App\Services\UserGroup;

use App\Models\UserGroup;
use App\Repositories\Contracts\IUserGroupRepository;
use App\Services\Contracts\IGroupService;
use App\Services\Contracts\ImLearnService;
use App\Services\Contracts\IUserGroupService;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserRepository.
 */
class UserGroupService implements IUserGroupService
{

    protected $userGroupRepository;
    protected $mLearnService;
    protected $groupService;

    public function __construct(
        IUserGroupRepository $userGroupRepository,
        ImLearnService $mLearnService,
        IGroupService $groupService
    )
    {
        $this->userGroupRepository = $userGroupRepository;
        $this->mLearnService = $mLearnService;
        $this->groupService = $groupService;
    }

    public function addUserToGroup(string $userId, string $groupId){
        $this->checkIfExistUserInGroup($userId, $groupId);
        $group = $this->groupService->getGroup($groupId);
        $this->mLearnService->addUserToGroupWithMLearn($userId, $group->id, $group->title);
        return $this->userGroupRepository->addUserToGroup($userId, $groupId);
    }
    public function removeUserToGroup(string $userId, string $groupId):void{
        $this->mLearnService->deleteUserGroupWithMLearn($userId, $groupId);
        $this->userGroupRepository->removeUserToGroup($userId, $groupId);
    }
    public function getGroupsOfUser(string $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->userGroupRepository->getGroupsOfUser($userId);
    }

    private function checkIfExistUserInGroup(string $userId, string $groupId){
        $group = $this->userGroupRepository->checkIfExistUserInGroup($userId, $groupId);
        if ($group)
            throw new \InvalidArgumentException('User already participates in this group!');
    }
}
