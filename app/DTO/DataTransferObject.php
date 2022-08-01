<?php

namespace App\DTO;


class DataTransferObject
{
    /** @var string  */
    public string $origin;
    /** @var string  */
    public string $destination;
    /** @var int  */
    public int $amount;
    /** @var array  */
    public array $carriers;



    /**
     * @param string $origin
     * @param string $destination
     * @param int $amount
     */
    public function __construct(string $origin, string $destination, int $amount,)
    {
        $this->origin = $origin;
        $this->destination = $destination;
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function getCarriers(): array
    {
        $carriers=app()->get('config')->get('carriers');
        $this->carriers=$carriers;
        return $this->carriers;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

}
