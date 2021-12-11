<?php

namespace App\Repositories\Contracts;

interface IUserGroupRepository {
    public function addUserToGroup(int $userId, int $groupId, int $role_id);
    public function removeUserToGroup(int $userId, int $groupId):void;
    public function getGroupsOfUser(int $userId);
    public function checkIfExistUserInGroup(int $userId, int $groupId);
}
