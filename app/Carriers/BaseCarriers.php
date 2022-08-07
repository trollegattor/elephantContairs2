<?php

namespace App\Carriers;

use App\Carriers\Exception\ExpirationDateException;
use App\Carriers\Exception\UnKnownPortException;
use App\DTO\DataTransferObject;
use Carbon\Carbon;

abstract class BaseCarriers
{
    /**
     * @var DataTransferObject
     */
    public DataTransferObject $dataTransfer;
    /** @var string */
    public string $carrier;

    /**
     * @param DataTransferObject $dataTransfer
     * @param string $carrier
     * @return CarrierModel
     * @throws ExpirationDateException
     * @throws UnKnownPortException
     */
    public function getRates(DataTransferObject $dataTransfer, string $carrier): CarrierModel
    {
        $this->dataTransfer = $dataTransfer;
        $this->carrier = $carrier;
        $rates = $this->getContent();
        $modelRates = $this->ModelRates($rates);
        $rate = $this->filterRates($modelRates);
        $this->validExpirationDate($rate);

        return $rate;
    }

    /**
     * @return array
     */
    protected function getContent(): array
    {
        $data = file_get_contents($this->dataTransfer->carriers[$this->carrier]);
        $decodeData = $this->decodeRates($data);

        return $decodeData;
    }

    /**
     * @param array $rates
     * @return CarrierModel
     * @throws UnKnownPortException
     */
    protected function filterRates(array $rates): CarrierModel
    {
        $rate = array_filter($rates, function ($data) {
            return $data->origin === $this->dataTransfer->origin &&
                $data->destination === $this->dataTransfer->destination;
        });
        if (empty($rate))
            throw new UnKnownPortException('Unknown Direction '.$this->dataTransfer->origin.'/'.$this->dataTransfer->destination);

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
    abstract protected function ModelRates(array $rates): array;

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
