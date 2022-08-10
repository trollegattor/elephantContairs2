<?php

namespace Tests\Feature;


use App\Carriers\Exception\InputDataException;
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
        $data=["data"=>[["carrier"=>"JSON","total_price"=>"3450.96","currency"=>"USD"],["carrier"=>"XML","total_price"=>"2080.60","currency"=>"USD"]]];
        $response->assertExactJson($data);
    }
    public function testGetPricesFailedValidFirst()
    {
        $this->expectExceptionMessage('Amount of containers  minimum 1; The origin port must only contain letters');
        $this->expectExceptionMessage('The origin port must only contain letters');
        $this->expectExceptionMessage('The destination port must only contain letters');
        $response=$this->get('/api/v1/quote/rates/0SBCN/0SMIA/1');
        $response->assertJsonValidationErrors([
            'origin',
            'destination',
            'amount',

        ]);


    }


}
