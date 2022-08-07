<?php

namespace App\Services\PriceService;

use App\DTO\DataTransferObject;
use App\Facades\TypesCarriers;
use App\Services\PriceService\Contracts\PriceServiceContract;

class PriceService implements PriceServiceContract
{
    /**
     * @param DataTransferObject $dataTransfer
     * @return array
     */
    public function getPrice(DataTransferObject $dataTransfer): array
    {
        $carriers = array_keys($dataTransfer->getCarriers());
        $total = [];
        foreach ($carriers as $value) {
            $element = TypesCarriers::driver($value . 'carrier')->getRates($dataTransfer, $value);
            $total[] = $element;
        }

        return $total;
    }
}
