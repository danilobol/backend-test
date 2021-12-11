<?php

namespace App\Services\Group;


use App\Repositories\Contracts\IGroupRepository;
use App\Services\Contracts\IGroupService;

/**
 * Class UserRepository.
 */
class GroupService implements IGroupService
{
    protected $groupRepository;

    public function __construct(
        IGroupRepository $groupRepository,
    )
    {
        $this->groupRepository = $groupRepository;
    }

    public function createNewGroup(string $name, int $institutions_id, int $owner_id, $amount){
        return $this->groupRepository->createNewGroup($name, $institutions_id, $owner_id, $amount);
    }

    public function getGroup(int $groupId){
        return $this->groupRepository->getGroup($groupId);
    }

    public function getOwnerUserGroups(int $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->groupRepository->getOwnerUserGroups($userId);
    }
}
