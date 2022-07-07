<?php

namespace App\Services\GetPriceService;

use Illuminate\Support\ServiceProvider;

class GetPriceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('json', function ($app) {
            return new \App\Services\GetPriceService\GetPriceService($app);
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
