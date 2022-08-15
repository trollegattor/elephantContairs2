<?php

namespace App\Services\CarrierService;

use App\Services\CarrierService\Contracts\CarriersServiceContract;
use Illuminate\Support\ServiceProvider;

class CarriersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CarriersServiceContract::class, CarriersService::class);
    }
}
