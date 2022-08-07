<?php

namespace Tests\Unit;

use App\Carriers\Exception\ExpirationDateException;
use App\Carriers\Exception\UnKnownPortException;
use App\Carriers\JsonCarrier;
use App\DTO\DataTransferObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;


class DriverJsonTest extends TestCase
{
    public string $carrier='JSON';
    /**
     * @return void
     * @throws ExpirationDateException
     * @throws UnKnownPortException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testCreateDriverJson()
    {
        $DTO=new DataTransferObject('ESBCN','USMIA',2);
        $DTO->getCarriers();
        $json=new JsonCarrier();
        $json->getRates($DTO,$this->carrier);

        


        dd($json);



    }
}
