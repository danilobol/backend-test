<?php

namespace App\Services\User;


use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\ImLearnService;
use App\Services\Contracts\IUserRoleService;
use App\Services\Contracts\IUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserService implements IUserService
{
    protected $userRepository;
    protected $userRoleService;
    protected $mLearnService;

    public function __construct(
        IUserRepository $userRepository,
        IUserRoleService $userRoleService,
        ImLearnService $mLearnService
    )
    {
        $this->userRepository = $userRepository;
        $this->userRoleService = $userRoleService;
        $this->mLearnService = $mLearnService;
    }

    public function registerUser(string $email, string $name, string $password){
        $validator = Validator::make(
            ['email' => $email],
            [
                'email' => 'required|email|unique:users,email',
            ],
        );

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        $user = $this->userRepository->createNewUser($email, $name, $password);
        $this->userRoleService->createUserRole($user->id, 2, $user->id);

        if (!$token = auth()->attempt(['email' => $email, 'password' => $password])){
            throw new \InvalidArgumentException('Unauthorized user, invalid data!');
        }
        $token = $this->createNewToken($token);
        return response()->json([
            'token' => $token,
            'status' => 'success',
            'message' => 'User created',
        ], 201);
    }

    public function loginUser(string $email, string $password){

        if ($token = auth()->attempt(['email' => $email, 'password' => $password])) {

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
            ]);
        } else {
            throw new \InvalidArgumentException('Unauthorized user!');
        }
    }

    private function createNewToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function findUser(int $id){
        return $this->userRepository->findUser($id);
    }


}
