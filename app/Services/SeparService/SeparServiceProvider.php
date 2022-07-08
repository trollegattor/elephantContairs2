<?php

namespace App\Services\SeparService;

use Illuminate\Support\ServiceProvider;

class SeparServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SeparService::class, function ($app) {
            return new SeparService();
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
