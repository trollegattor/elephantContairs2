<?php

namespace App\Carriers;

use Carbon\Carbon;

class CarrierModel
{
    /**
     * @param string $carrier
     * @param string $origin
     * @param string $destination
     * @param string $pricePerContainer
     * @param string $pricePerShipment
     * @param string $currency
     * @param string $total_price
     * @param Carbon $expiresAt
     */
    public function __construct(
        public string $carrier,
        public string $origin,
        public string $destination,
        public string $pricePerContainer,
        public string $pricePerShipment,
        public string $currency,
        public string $total_price,
        public Carbon $expiresAt)
    {
    }

}
