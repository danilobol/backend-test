<?php

namespace App\Services\Group;


use App\Repositories\Contracts\IGroupRepository;
use App\Repositories\Contracts\IUserGroupRepository;
use App\Services\Contracts\IGroupService;
use App\Services\Contracts\IUserGroupService;

/**
 * Class UserRepository.
 */
class GroupService implements IGroupService
{
    protected $groupRepository;
    protected $userGroupRepository;

    public function __construct(
        IGroupRepository $groupRepository,
        IUserGroupRepository $userGroupRepository
    )
    {
        $this->groupRepository = $groupRepository;
        $this->userGroupRepository = $userGroupRepository;
    }

    public function createNewGroup(string $name, int $institutions_id, int $owner_id, $amount){

        $infoGroup = $this->groupRepository->createNewGroup($name, $institutions_id, $owner_id, $amount);
        $this->userGroupRepository->addUserToGroup($owner_id, $infoGroup->id, 'admin');
        return $infoGroup;
    }

    public function getGroup(int $groupId){
        return $this->groupRepository->getGroup($groupId);
    }

    public function getOwnerUserGroups(int $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->groupRepository->getOwnerUserGroups($userId);
    }
}
