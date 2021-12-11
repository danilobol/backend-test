<?php

namespace App\Services\Contracts;

interface IUserGroupService {
    public function addUserToGroup(string $userId, string $groupId);
    public function removeUserToGroup(string $userId, string $groupId):void;
    public function getGroupsOfUser(string $userId);
}
