<?php

namespace App\Providers;

use App\Services\Impl\ItemServiceImpl;
use App\Services\Impl\StockHistoryServiceImpl;
use App\Services\Impl\TransactionServiceImpl;
use App\Services\Impl\TransactionWrapperServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\ItemService;
use App\Services\StockHistoryService;
use App\Services\TransactionService;
use App\Services\TransactionWrapperService;
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
        $this->app->singleton(TransactionWrapperService::class, function ($app) {
            return $app->make(TransactionWrapperServiceImpl::class);
        });
        $this->app->singleton(TransactionService::class, function ($app) {
            return new TransactionServiceImpl($app->make(ItemService::class));
        });
        $this->app->singleton(StockHistoryService::class, function ($app) {
            return $app->make(StockHistoryServiceImpl::class);
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
