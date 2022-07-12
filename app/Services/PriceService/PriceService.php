<?php

namespace App\Services\PriceService;

use App\Carriers\MyCarriers;
use App\Facades\TypesCarriers;

class PriceService
{
    /**
     * @param $request
     * @return array
     */
    public function getPrice($request): array
    {
        $total = [];
        foreach (MyCarriers::LIST as $value) {
            $element = TypesCarriers::driver($value . 'carrier')->getJson($request);
            $total[] = $element;
        }

        return $total;
    }
}
