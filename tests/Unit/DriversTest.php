<?php

namespace Tests\Unit;

use App\Carriers\CarrierModel;
use App\Carriers\Exception\ExpirationDateException;
use App\Carriers\Exception\UnKnownPortException;
use App\Managers\TypeManager;
use Carbon\Carbon;
use Tests\TestCase;
use Tests\CreatesApplication;

class DriversTest extends TestCase
{
    /**
     * @return void
     * @throws ExpirationDateException
     * @throws UnKnownPortException
     */
    public function testCreateDriverJson()
    {
        $modelJson=new CarrierModel(
            carrier: 'JSON',
            origin: 'ESBCN',
            destination: 'USMIA',
            pricePerContainer: 1707.53,
            pricePerShipment: 35.9,
            currency: 'USD',
            total_price:'0',
            expiresAt: Carbon::createFromFormat('Y-m-d', '2023-04-29')->setTime(0, 33,54)
        );
        $manager=app(TypeManager::class);
        $managerJson=$manager->driver('Jsoncarrier')->getRates( 'ESBCN', 'USMIA', 'JSON');
        $this->assertEquals($modelJson, $managerJson);
    }
    public function testCreateDriverXML()
    {
        $modelXml=new CarrierModel(
            carrier: 'XML',
            origin: 'ESBCN',
            destination: 'USMIA',
            pricePerContainer: 1040.3,
            pricePerShipment: 0,
            currency: 'USD',
            total_price:'0',
            expiresAt: Carbon::createFromFormat('Y-m-d', '2023-03-09')->setTime(0, 0)
        );
        $manager=app(TypeManager::class);
        $managerXml=$manager->driver('Xmlcarrier')->getRates( 'ESBCN', 'USMIA', 'XML');
        $this->assertEquals($modelXml,$managerXml);
    }
    public function testCreateDriverDefault()
    {
        $modelJson=new CarrierModel(
            carrier: 'JSON',
            origin: 'ESBCN',
            destination: 'USMIA',
            pricePerContainer: 1707.53,
            pricePerShipment: 35.9,
            currency: 'USD',
            total_price:'0',
            expiresAt: Carbon::createFromFormat('Y-m-d', '2023-04-29')->setTime(0, 33,54)
        );
        $manager=app(TypeManager::class);
        $managerJson=$manager->getRates('ESBCN', 'USMIA', 'JSON');
        $this->assertEquals($modelJson, $managerJson);
    }
}
