<?php

namespace App\Services\FlipPriceService;

use App\Services\FlipPriceService\Contracts\FlipPriceServiceContract;
use Illuminate\Support\ServiceProvider;

class FlipPriceServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlipPriceServiceContract::class, FlipPriceService::class);
    }
}
