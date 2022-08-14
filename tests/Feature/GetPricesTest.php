<?php

namespace Tests\Feature;

use App\Carriers\Exception\InputDataException;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class GetPricesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetExpectedAnswer()
    {
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $data = ["data" => [["carrier" => "JSON", "total_price" => "3450.96", "currency" => "USD"], ["carrier" => "XML", "total_price" => "2080.60", "currency" => "USD"]]];
        $response->assertExactJson($data);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidFirst()
    {
        $response = $this->get('/api/v1/quote/rates/5SBCN/5SMIA/foo');
        $response->assertJson(['The origin must only contain letters.; The destination must only contain letters.; The amount must be an integer.']);

    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidSecond()
    {
        $response = $this->get('/api/v1/quote/rates/EESBCN/EESMIA/0');
        $response->assertJson(['The origin must be 5 characters.; The destination must be 5 characters.; The amount must be at least 1.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidThird()
    {
        $response = $this->get('/api/v1/quote/rates/eSBCN/eSMIA/1');
        $response->assertJson(['The origin must be uppercase.; The destination must be uppercase.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidUnknownPort()
    {
        $response = $this->get('/api/v1/quote/rates/FFFFF/ESMIA/1');
        $response->assertJson(['Unknown Direction FFFFF/ESMIA']);
    }
    /**
     * @return void
     */
    public function testGetPricesFailedValidExpirationDateJson()
    {
        Config::set('carriers.JSON', storage_path('app/tests/datecarrier-json.json'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Data is out of date, please update the carrier "JSON".']);
    }
    /**
     * @return void
     */
    public function testGetPricesFailedValidExpirationDateXML()
    {
        Config::set('carriers.XML', storage_path('app/tests/datecarrier-xml.xml'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Data is out of date, please update the carrier "XML".']);
    }
    /**
     * @return void
     */
    public function testGetPricesFailedValidFormatJson()
    {
        Config::set('carriers.JSON', storage_path('app/tests/formatcarrier-json.json'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Unknown format from Json carrier.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidFormatXML()
    {
        Config::set('carriers.XML', storage_path('app/tests/formatcarrier-xml.xml'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Unknown format from XML carrier.']);
    }

    /**
     * @return void
     */
    public function testGetPricesFailedValidCurrencyJson()
    {
        Config::set('carriers.JSON', storage_path('app/tests/currencycarrier-json.json'));
        $response = $this->get('/api/v1/quote/rates/ESBCN/USMIA/2');
        $response->assertJson(['Unknown currency symbol "g".']);
    }


}
