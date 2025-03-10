<?php

namespace App\Providers;

use App\Services\Impl\ItemServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\ItemService;
use App\Services\UserService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TransactionLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        // item service
        $this->app->singleton(ItemService::class, function ($app) {
            return $app->make(ItemServiceImpl::class);
        });
        $this->app->singleton(UserService::class, function ($app) {
            return $app->make(UserServiceImpl::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
