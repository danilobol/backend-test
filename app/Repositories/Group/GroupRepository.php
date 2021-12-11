<?php

namespace App\Repositories\Group;


use App\Models\Group;
use App\Repositories\Contracts\IGroupRepository;

/**
 * Class UserRepository.
 */
class GroupRepository implements IGroupRepository
{
    public function createNewGroup(string $name, int $institutions_id, int $owner_id, $amount){
        return Group::create([
            'name'              => $name,
            'institutions_id'   => $institutions_id,
            'owner_id'          => $owner_id,
            'amount'            => $amount,
        ]);
    }

    public function getGroup(int $groupId){
        return Group::query()->where('id','=', $groupId)->first();
    }

    public function getOwnerUserGroups(string $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return Group::query()->where('owner_id', '=', $userId)->get();
    }
}
