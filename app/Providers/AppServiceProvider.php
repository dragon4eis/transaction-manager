<?php

namespace App\Providers;

use App\Services\TransactionService;
use App\Services\TransactionServiceInterface;
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
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
    }
}
