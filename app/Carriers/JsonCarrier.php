<?php

namespace App\Carriers;

use App\Carriers\Exception\UnKnownCurrencySymbolException;
use App\Carriers\Exception\UnknownJsonFormatException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class JsonCarrier extends BaseCarriers
{
    /**
     * @param string $data
     * @return array
     * @throws UnknownJsonFormatException
     */
    protected function decodeRates(string $data): array
    {
        $this->validRates($data);
        $jsonData = json_decode($data);
        if (gettype($jsonData) != 'array')
            return array($jsonData);

        return $jsonData;
    }

    /**
     * @param $data
     * @return void
     * @throws UnknownJsonFormatException
     */
    protected function validRates($data): void
    {
        $validator = Validator::make(['array' => $data], ['array' => 'json']);
        if ($validator->fails())
            throw new UnknownJsonFormatException("Unknown format from Json carrier.");
    }

    /**
     * @param array $rates
     * @param string $carrier
     * @return array
     * @throws UnKnownCurrencySymbolException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function modelRates(array $rates, string $carrier): array
    {
        array_walk($rates, function (&$data) use ($carrier) {
            $data = new CarrierModel(
                carrier: $carrier,
                origin: strtoupper($data->origin),
                destination: strtoupper($data->destination),
                pricePerContainer: (string)$data->price_per_container,
                pricePerShipment: (string)$data->price_per_shipment,
                currency: Currency::getCurrency($data->currency),
                total_price: '0',
                expiresAt: Carbon::createFromTimestamp($data->max_date));
        });

        return $rates;
    }
}
