<?php

namespace App\Services\CarrierService;

use App\Facades\TypesCarriers;
use App\Services\CarrierService\Contracts\CarriersServiceContract;

class CarriersService implements CarriersServiceContract
{
    /**
     * @param string $origin
     * @param string $destination
     * @return array
     */
    public function getPrice(string $origin, string $destination): array
    {
        $carriers = array_keys(config('carriers'));
        $total = [];
        foreach ($carriers as $value) {
            $element = TypesCarriers::driver($value . 'carrier')->getRates($origin, $destination, $value);
            $total[] = $element;
        }

        return $total;
    }
}
