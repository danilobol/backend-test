<?php

namespace App\Providers;

use App\Repositories\Contracts\IGroupRepository;
use App\Repositories\Contracts\IInstitutionRepository;
use App\Repositories\Contracts\IProductRepository;
use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IUserGroupRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Contracts\IUserRoleRepository;
use App\Repositories\Group\GroupRepository;
use App\Repositories\Institution\InstitutionRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\UserGroup\UserGroupRepository;
use App\Repositories\UserRole\UserRoleRepository;
use App\Services\Contracts\IGroupService;
use App\Services\Contracts\IInstitutionService;
use App\Services\Contracts\IProductService;
use App\Services\Contracts\ITransactionService;
use App\Services\Contracts\IUserGroupService;
use App\Services\Contracts\IUserRoleService;
use App\Services\Contracts\IUserService;
use App\Services\Group\GroupService;
use App\Services\Institution\InstitutionService;
use App\Services\Product\ProductService;
use App\Services\Transaction\TransactionService;
use App\Services\User\UserService;
use App\Services\UserGroup\UserGroupService;
use App\Services\UserRole\UserRoleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

        //services
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IUserRoleService::class, UserRoleService::class);
        $this->app->bind(IUserGroupService::class, UserGroupService::class);
        $this->app->bind(IGroupService::class, GroupService::class);
        $this->app->bind(IInstitutionService::class, InstitutionService::class);
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(ITransactionService::class, TransactionService::class);


        //repositories
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserRoleRepository::class, UserRoleRepository::class);
        $this->app->bind(IUserGroupRepository::class, UserGroupRepository::class);
        $this->app->bind(IGroupRepository::class, GroupRepository::class);
        $this->app->bind(IInstitutionRepository::class, InstitutionRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ITransactionRepository::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
