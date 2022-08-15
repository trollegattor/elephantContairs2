<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class GetPricesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetExpectedAnswer(): void
    {
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $data = ["data" => [["carrier" => "JSON", "total_price" => "3450.96", "currency" => "USD"], ["carrier" => "XML", "total_price" => "2080.60", "currency" => "USD"]]];
        $response->assertExactJson($data);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidFirst(): void
    {
        $response = $this->get('/api/v1/quote/rates/5SBCN/5SMIA/foo');
        $response->assertJson(['The origin must only contain letters.; The destination must only contain letters.; The amount must be an integer.']);

    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidSecond(): void
    {
        $response = $this->get('/api/v1/quote/rates/EESBCN/EESMIA/0');
        $response->assertJson(['The origin must be 5 characters.; The destination must be 5 characters.; The amount must be at least 1.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidThird(): void
    {
        $response = $this->get('/api/v1/quote/rates/eSBCN/eSMIA/1');
        $response->assertJson(['The origin must be uppercase.; The destination must be uppercase.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidUnknownPort(): void
    {
        $response = $this->get('/api/v1/quote/rates/FFFFF/ESMIA/1');
        $response->assertJson(['Unknown Direction FFFFF/ESMIA']);
    }
    /**
     * @return void
     */
    public function testGetPricesFailedValidExpirationDateJson(): void
    {
        Config::set('carriers.JSON', storage_path('app/tests/datecarrier-json.json'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Data is out of date, please update the carrier "JSON".']);
    }
    /**
     * @return void
     */
    public function testGetPricesFailedValidExpirationDateXML(): void
    {
        Config::set('carriers.XML', storage_path('app/tests/datecarrier-xml.xml'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Data is out of date, please update the carrier "XML".']);
    }
    /**
     * @return void
     */
    public function testGetPricesFailedValidFormatJson(): void
    {
        Config::set('carriers.JSON', storage_path('app/tests/formatcarrier-json.json'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Unknown format from Json carrier.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidFormatXML(): void
    {
        Config::set('carriers.XML', storage_path('app/tests/formatcarrier-xml.xml'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Unknown format from XML carrier.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidCurrencyJson(): void
    {
        Config::set('carriers.JSON', storage_path('app/tests/currencycarrier-json.json'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Unknown currency symbol "g".']);
    }
}
