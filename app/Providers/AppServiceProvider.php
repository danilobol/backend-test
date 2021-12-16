<?php

namespace App\Providers;

use App\Repositories\Contracts\IInvestmentRepository;
use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Investment\InvestmentRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Contracts\IInvestmentService;
use App\Services\Contracts\ITransactionService;
use App\Services\Contracts\IUserService;
use App\Services\Investment\InvestmentService;
use App\Services\Transaction\TransactionService;
use App\Services\User\UserService;
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
        $this->app->bind(IInvestmentService::class, InvestmentService::class);
        $this->app->bind(ITransactionService::class, TransactionService::class);


        //repositories
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IInvestmentRepository::class, InvestmentRepository::class);
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
