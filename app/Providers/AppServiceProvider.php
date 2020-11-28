<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Observers\TransactionObserver;
use App\Services\TransactionService;
use App\Services\TransactionServiceInterface;
use App\Services\UserService;
use App\Services\UserServiceInterface;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //services
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);

        //observers
        Transaction::observe(TransactionObserver::class);
    }
}
