<?php

namespace App\Services\FlipPriceService;

use App\DTO\DataTransferObject;
use App\Services\FlipPriceService\Contracts\FlipPriceServiceContract;

class FlipPriceService implements FlipPriceServiceContract
{
    /**
     * @param array $carriers
     * @param DataTransferObject $inputData
     * @return array
     */
    public function getTotalPrice(array $carriers, DataTransferObject $inputData): array
    {
        array_map(function ($data) use ($inputData) {
            $priceContainers = bcmul($inputData->amount, $data->pricePerContainer, 2);
            $data->total_price = bcadd($priceContainers, $data->pricePerShipment, 2);

            return $data;
        }, $carriers);

        return $carriers;
    }
}
