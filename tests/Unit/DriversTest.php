<?php

namespace Tests\Unit;

use App\Carriers\CarrierModel;
use App\Managers\TypeManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class DriversTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateDriverJson(): void
    {
        $date = $this->getDate();
        $modelJson = new CarrierModel(
            carrier: 'JSON',
            origin: 'ESBCN',
            destination: 'USMIA',
            pricePerContainer: 1707.53,
            pricePerShipment: 35.9,
            currency: 'USD',
            total_price: '0',
            expiresAt: Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0)
        );
        $jsonData = $this->createFileJson($modelJson);
        Storage::put('test/carrier-json.json', $jsonData);
        Config::set('carriers.JSON', storage_path('app/test/carrier-json.json'));
        $manager = app(TypeManager::class);
        $managerJson = $manager->driver('Jsoncarrier')->getRates('ESBCN', 'USMIA', 'JSON');
        $this->assertEquals($modelJson, $managerJson);
        Storage::delete('test/carrier-json.json');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCreateDriverXML(): void
    {
        $date = $this->getDate();
        $modelXml = new CarrierModel(
            carrier: 'XML',
            origin: 'ESBCN',
            destination: 'USMIA',
            pricePerContainer: 1040.3,
            pricePerShipment: 0,
            currency: 'USD',
            total_price: '0',
            expiresAt: Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0)
        );
        $xmlData = $this->createFileXml($modelXml);
        Storage::put('test/carrier-xml.xml', $xmlData->asXML());
        Config::set('carriers.XML', storage_path('app/test/carrier-xml.xml'));
        $manager = app(TypeManager::class);
        $managerXml = $manager->driver('Xmlcarrier')->getRates('ESBCN', 'USMIA', 'XML');
        $this->assertEquals($modelXml, $managerXml);
        Storage::delete('test/carrier-xml.xml');
    }

    /**
     * @return void
     */
    public function testCreateDriverDefault(): void
    {
        $date = $this->getDate();
        $modelJson = new CarrierModel(
            carrier: 'JSON',
            origin: 'ESBCN',
            destination: 'USMIA',
            pricePerContainer: 1707.53,
            pricePerShipment: 35.9,
            currency: 'USD',
            total_price: '0',
            expiresAt: Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0)
        );
        $jsonData = $this->createFileJson($modelJson);
        Storage::put('test/carrier-json.json', $jsonData);
        Config::set('carriers.JSON', storage_path('app/test/carrier-json.json'));
        $manager = app(TypeManager::class);
        $managerJson = $manager->getRates('ESBCN', 'USMIA', 'JSON');
        $this->assertEquals($modelJson, $managerJson);
        Storage::delete('test/carrier-json.json');
    }

    /**
     * @return string
     */
    protected function getDate(): string
    {
        $date = Carbon::now()->addDays(30);

        return $date->format('Y-m-d');
    }

    /**
     * @param $model
     * @return SimpleXMLElement
     * @throws Exception
     */
    protected function createFileXml($model): SimpleXMLElement
    {
        $xmlData = ['currency' => $model->currency,
            'destination_port' => $model->destination,
            'expiration_date' => $model->expiresAt->format('Y-m-d'),
            'origin_port' => $model->origin,
            'price_per_container' => $model->pricePerContainer
        ];
        $xmlStr = "<?xml version='1.0' encoding='UTF-8' ?><root><route></route></root>";
        $xml = new SimpleXMLElement($xmlStr);
        foreach ($xmlData as $key => $value) {
            $xml->route[0]->$key = $value;
        }

        return $xml;
    }

    /**
     * @param $model
     * @return string
     */
    protected function createFileJson($model): string
    {
        $jsonData = [
            'origin' => $model->origin,
            'destination' => $model->destination,
            'max_date' => $model->expiresAt->getTimestamp(),
            'price_per_container' => $model->pricePerContainer,
            'price_per_shipment' => $model->pricePerShipment,
            'currency' => "$",
        ];
        $json = json_encode($jsonData);

        return $json;
    }
}
