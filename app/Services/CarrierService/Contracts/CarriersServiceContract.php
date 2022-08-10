<?php

namespace App\Services\CarrierService\Contracts;

use App\InitialData\InitialDataObject;

interface CarriersServiceContract
{
    /**
     * @param string $origin
     * @param string $destination
     * @return array
     */
    public function getPrice(string $origin,string $destination): array;
}
