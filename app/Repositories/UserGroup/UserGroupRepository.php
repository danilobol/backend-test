<?php

namespace App\Repositories\UserGroup;


use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use App\Repositories\Contracts\IUserGroupRepository;

/**
 * Class UserRepository.
 */
class UserGroupRepository implements IUserGroupRepository
{
    public function addUserToGroup(int $userId, int $groupId, string $type){
        return UserGroup::create([
            'user_id'       => $userId,
            'group_id'      => $groupId,
            'type'          => $type
        ]);
    }
    public function removeUserToGroup(int $userId, int $groupId):void{
        $userGroup = UserGroup::query()
            ->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)->first();
        $userGroup?->delete();
    }
    public function getGroupsOfUser(int $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return UserGroup::query()->where('user_id', '=', $userId)
            ->with('group')
            ->get();
    }

    public function checkIfExistUserInGroup(int $userId, int $groupId)
    {
        return UserGroup::query()
            ->where('user_id','=', $userId)
            ->where('group_id','=', $groupId)->first();
    }
}
