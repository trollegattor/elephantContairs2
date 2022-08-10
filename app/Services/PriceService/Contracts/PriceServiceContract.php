<?php

namespace App\Services\PriceService\Contracts;
interface PriceServiceContract
{
    /**
     * @param array $carriers
     * @param string $amount
     * @return array
     */
    public function getTotalPrice(array $carriers, string $amount): array;
}
