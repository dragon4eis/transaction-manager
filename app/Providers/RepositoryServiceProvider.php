<?php

namespace App\Providers;

use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
