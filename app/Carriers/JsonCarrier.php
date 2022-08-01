<?php

namespace App\Carriers;

use App\Carriers\Exception\UnKnownCurrencySymbolException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class JsonCarrier extends BaseCarriers
{

    /**
     * @param string $data
     * @return array
     * @throws UnKnownCurrencySymbolException
     */
    protected function decodeRates(string $data): array
    {
        $this->validRates($data);
        $jsonData = json_decode($data);

        return $jsonData;
    }

    /**
     * @param string $data
     * @return array
     * @throws UnKnownCurrencySymbolException
     */
    protected function validRates(string $data): array
    {
        $validator = Validator::make(['array' => $data], ['array' => 'json']);
        if ($validator->fails())
            throw new UnKnownCurrencySymbolException("Unknown format \"$data\".");

        return [];
    }

    /**
     * @param array $rates
     * @return array
     * @throws UnKnownCurrencySymbolException
     */
    protected function ModelRates(array $rates): array
    {
        array_walk($rates, function (&$data) {
            $data = new CarrierModel(
                carrier: $this->carrier,
                origin: strtoupper($data->origin),
                destination: strtoupper($data->destination),
                pricePerContainer: (string)$data->price_per_container,
                pricePerShipment: (string)$data->price_per_shipment,
                currency: Currency::getCurrency($data->currency),
                total_price:'0',
                expiresAt: Carbon::createFromTimestamp($data->max_date));
        });

        return $rates;
    }
}
