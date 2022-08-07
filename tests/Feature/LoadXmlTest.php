<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LoadXmlTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoadFileXml()
    {
        Storage::fake('carrier');


        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
