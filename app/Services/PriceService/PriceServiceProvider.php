<?php

namespace App\Services\PriceService;

use App\Services\PriceService\Contracts\PriceServiceContract;
use Illuminate\Support\ServiceProvider;

class PriceServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(PriceServiceContract::class, PriceService::class);
    }
}
