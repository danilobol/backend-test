<?php

namespace App\Repositories\User;


use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

/**
 * Class UserRepository.
 */
class UserRepository implements IUserRepository
{
    public function createNewUser(string $email, string $name, string $password){
        return User::create([
            'email'     => $email,
            'name'     => $name,
            'password'  => bcrypt($password)
        ]);
    }
    public function findUser(int $id){
        return User::find($id);
    }
}
