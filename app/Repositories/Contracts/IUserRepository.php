<?php

namespace App\Repositories\Contracts;

interface IUserRepository {
    public function createNewUser(string $email, string $name, string $password);
    public function findUser(int $id);
}
