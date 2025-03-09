<?php

namespace App\Providers;

use App\Services\Impl\ItemServiceImpl;
use App\Services\ItemService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TransactionLayerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public array $singletons = [
        ItemService::class => ItemServiceImpl::class
    ];

    public function provides(): array
    {
        return [ItemService::class];
    }



    public function register()
    {
        // item service
        $this->app->singleton(ItemService::class, function ($app) {
            return $app->make(ItemServiceImpl::class);
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
