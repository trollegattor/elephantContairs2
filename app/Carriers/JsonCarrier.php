<?php
namespace App\Carriers;

use App\Services\SeparService\SeparService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class JsonCarrier
{
    public function getJson($request)
    {
        $data=Storage::get('carrier-json.json');
        $data=json_decode($data);
        foreach ($data as $datum)
        {
            if($datum->max_date){
                //dd($datum->max_date);
            }
            if (Str::upper($datum->origin)==$request->get('origin')
            and Str::upper($datum->destination)==$request->get('destination'))
            {
                $newData=[
                    'carrier'=>'JSON',
                    'total_price'=>round($datum->price_per_container*$request->get('amount'),2),
                    'currency'=>$datum->currency
                ];

                return $newData;

            }
            $origin = $datum->origin;
            $destination = $datum->destination;
            $price_container = $datum->price_per_container;
            $expiration_date = $datum->max_date;
            $currency = $datum->currency;
            $expiration_date1 = $datum->max_date;
            $array=[$origin,$destination,$price_container,$expiration_date,$currency ];


        }

      //  return $dataJson;
    }

}
