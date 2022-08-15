<?php

namespace App\Services\PriceService;

use App\Services\PriceService\Contracts\PriceServiceContract;

class PriceService implements PriceServiceContract
{
    /**
     * @param array $carriers
     * @param string $amount
     * @return array
     */
    public function getTotalPrice(array $carriers, string $amount): array
    {
        array_map(function ($data) use ($amount) {
            $priceContainers = bcmul($amount, $data->pricePerContainer, 2);
            $data->total_price = bcadd($priceContainers, $data->pricePerShipment, 2);

            return $data;
        }, $carriers);

        return $carriers;
    }
}
