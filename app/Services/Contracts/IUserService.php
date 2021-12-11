<?php

namespace App\Services\Contracts;

interface IUserService {
    public function registerUser(string $email, string $name, string $password);
    public function loginUser(string $email, string $password);
    public function findUser(int $id);
}
