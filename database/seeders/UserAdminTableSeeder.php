<?php

namespace Database\Seeders;


use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IMerchantService;
use App\Services\Contracts\IProfileService;
use App\Services\Contracts\IUserRoleService;
use App\Services\Contracts\IUserService;
use Illuminate\Database\Seeder;

class UserAdminTableSeeder extends Seeder
{
    protected $userService;
    protected $userRoleService;

    public function __construct(
        IUserRepository $userService,
        IUserRoleService $userRoleService,
    ){
        $this->userService = $userService;
        $this->userRoleService = $userRoleService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdmin = $this->userService->createNewUser(
            'admin@admin.com',
            'admin',
            'admin'
        );

        $this->userRoleService->createUserRole($userAdmin->id, 1, $userAdmin->id);
        $this->userRoleService->createUserRole($userAdmin->id, 2, $userAdmin->id);
    }
}
