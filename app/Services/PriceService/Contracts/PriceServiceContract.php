<?php

namespace App\Services\PriceService\Contracts;

use App\DTO\DataTransferObject;

interface PriceServiceContract
{
    /**
     * @param DataTransferObject $dataTransfer
     * @return array
     */
    public function getPrice(DataTransferObject $dataTransfer): array;
}
