<?php

namespace App\Carriers;

use App\Rules\XmlRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class XmlCarrier extends BaseCarriers
{
    /**
     * @param string $data
     * @return array
     */
    protected function decodeRates(string $data): array
    {
        $this->validRates($data);
        $xmlData = simplexml_load_string($data);
        $arrayXmlData = (array)json_decode(json_encode($xmlData));
        $finalArrayXmlData = array_pop($arrayXmlData);

        return $finalArrayXmlData;
    }

    /**
     * @param string $data
     * @return void
     */
    protected function validRates(string $data): void
    {
        $validator = Validator::make(['array' => $data], ['array' => new XmlRule]);
        $validator->fails();
    }

    /**
     * @param array $rates
     * @param string $carrier
     * @return array
     */
    protected function modelRates(array $rates, string $carrier): array
    {
        array_walk($rates, function (&$data) use ($carrier) {
            $data = new CarrierModel(
                carrier: $carrier,
                origin: strtoupper($data->origin_port),
                destination: strtoupper($data->destination_port),
                pricePerContainer: (string)$data->price_per_container,
                pricePerShipment: '0',
                currency: (string)$data->currency,
                total_price: '0',
                expiresAt: Carbon::createFromFormat('Y-m-d', $data->expiration_date)->setTime(0, 0)
            );
        });

        return $rates;
    }
}
