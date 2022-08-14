<?php

namespace App\Carriers;

use App\Carriers\Exception\ExpirationDateException;
use App\Carriers\Exception\UnKnownPortException;
use Carbon\Carbon;

abstract class BaseCarriers
{
    /**
     * @param string $origin
     * @param string $destination
     * @param string $carrier
     * @return CarrierModel
     * @throws ExpirationDateException
     * @throws UnKnownPortException
     */
    public function getRates( string $origin,string $destination, string $carrier): CarrierModel
    {
        $rates = $this->getContent($carrier);
        $modelRates = $this->modelRates($rates,$carrier);
        $rate = $this->filterRates($modelRates,$origin,$destination);
        $this->validExpirationDate($rate);
        return $rate;
    }

    /**
     * @return array
     */
    protected function getContent($carrier): array
    {
        $path=config('carriers');
        $data = file_get_contents($path[$carrier]);
        $decodeData = $this->decodeRates($data);

        return $decodeData;
    }

    /**
     * @param array $rates
     * @return CarrierModel
     * @throws UnKnownPortException
     */
    protected function filterRates(array $rates,string $origin,string $destination): CarrierModel
    {
        $rate = array_filter($rates, function ($data) use($origin,$destination){
            return $data->origin === $origin &&
                $data->destination === $destination;
        });
        if (empty($rate))
            throw new UnKnownPortException('Unknown Direction ' . $origin . '/' . $destination);

        return array_pop($rate);
    }

    protected function validExpirationDate($rate)
    {
        if ($rate->expiresAt->lt((new Carbon())->toDateTimeString()))
            throw new ExpirationDateException("Data is out of date, please update the carrier \"$rate->carrier\".");
    }

    /**
     * @param array $rates
     * @return array
     */
    abstract protected function modelRates(array $rates,string $carrier): array;

    /**
     * @param string $data
     * @return void
     */
    abstract protected function validRates(string $data);

    /**
     * @param string $data
     * @return array
     */
    abstract protected function decodeRates(string $data): array;
}
