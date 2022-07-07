<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Port;
use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $barcelona=Port::query()->create([
            'name'=>'Barcelona',
            'iso_code'=> 'ESBCN',
            'country'=> 'ES'
        ]);
        $valencia=Port::query()->create([
            'name'=>'Valencia',
            'iso_code'=> 'ESVLC',
            'country'=> 'ES'
        ]);
        $museul=Port::query()->create([
            'name'=>'Musel',
            'iso_code'=> 'ESMUS',
            'country'=> 'ES'
        ]);
        $aviles=Port::query()->create([
            'name'=>'Aviles',
            'iso_code'=> 'ESAVS',
            'country'=> 'ES'
        ]);
        $florida=Port::query()->create([
            'name'=>'Florida',
            'iso_code'=> 'USMIA',
            'country'=> 'US'
        ]);
        $usd=Currency::query()->create([
            'name'=>'USD',
            'symbol'=>'$',
        ]);
        $euro=Currency::query()->create([
            'name'=>'EUR',
            'symbol'=>'€',
        ]);
        Price::query()->create([
            'carrier'=>'xml',
            'origin'=>$barcelona->id,
            'destination'=>$valencia->id,
            'price_container'=>4819.57,
            'expiration_date'=>date('Y-m-d',mktime(0,0,0, 7,10,2022)),
            'currency_id'=>$usd->id,
        ]);
        Price::query()->create([
            'carrier'=>'JSON',
            'origin'=>$barcelona->id,
            'destination'=>$valencia->id,
            'price_container'=>672.05,
            'expiration_date'=>date('Y-m-d',mktime(0,0,0, 7,10,2022)),
            'currency_id'=>$usd->id,
        ]);
        Price::query()->create([
            'carrier'=>'xml',
            'origin'=>$barcelona->id,
            'destination'=>$museul->id,
            'price_container'=>3359.05,
            'expiration_date'=>date('Y-m-d',mktime(0,0,0, 7,10,2022)),
            'currency_id'=>$usd->id,
        ]);
        Price::query()->create([
            'carrier'=>'JSON',
            'origin'=>$barcelona->id,
            'destination'=>$museul->id,
            'price_container'=>4146.93,
            'expiration_date'=>date('Y-m-d',mktime(0,0,0, 7,10,2022)),
            'currency_id'=>$usd->id,
        ]);

    }
}
