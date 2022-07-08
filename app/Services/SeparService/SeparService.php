<?php
namespace App\Services\SeparService;
class SeparService
{
    public function Separ($data,$request)
    {

        foreach ($data as $datum)
        {
            //dump($datum);

           $origin = $datum->origin;
            $destination = $datum->destination;
            $price_container = $datum->price_per_container;
            $expiration_date = $datum->max_date;
            $currency = $datum->currency;
            $expiration_date1 = $datum->max_date;
            $array=[$origin,$destination,$price_container,$expiration_date,$currency ];


            print_r($array);
            print_r('<br>');

        }





    }

}
