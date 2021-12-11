<?php

namespace App\Services\Contracts;

interface IGroupService {
    public function createNewGroup(string $name, int $institutions_id, int $owner_id, $amount);
    public function getGroup(int $groupId);
    public function getOwnerUserGroups(int $userId): \Illuminate\Database\Eloquent\Collection|array;
}
