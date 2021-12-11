<?php

namespace App\Repositories\Contracts;

interface IGroupRepository {
    public function createNewGroup(string $name, int $institutions_id, int $owner_id, $amount);
    public function getGroup(string $groupId);
    public function getOwnerUserGroups(string $userId): \Illuminate\Database\Eloquent\Collection|array;
}
