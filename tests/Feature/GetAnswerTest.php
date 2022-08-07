<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAnswerTest extends TestCase
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
}
