<?php

namespace App\Services\Contracts;

interface IUserGroupService {
    public function addUserToGroup(int $userId, int $groupId, string $type);
    public function removeUserToGroup(int $userId, int $groupId):void;
    public function getGroupsOfUser(int $userId);
}
