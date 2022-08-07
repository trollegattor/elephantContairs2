<?php

namespace App\Services\FlipPriceService\Contracts;

use App\DTO\DataTransferObject;

interface FlipPriceServiceContract
{
    /**
     * @param array $carriers
     * @param DataTransferObject $inputData
     * @return array
     */
    public function getTotalPrice(array $carriers, DataTransferObject $inputData): array;
}
