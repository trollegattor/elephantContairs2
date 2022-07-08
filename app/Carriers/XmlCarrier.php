<?php

namespace App\Carriers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;

class XmlCarrier
{
    public function getJson($request)
    {
        $data = Storage::get('carrier-xml.xml');
        $data = new SimpleXMLElement($data);
        //dd($data);
        foreach ($data as $datum) {
            if ($datum->expiration_date) {
                //dd($datum->max_date);
            }
            if ((string)$datum->origin_port == $request->get('origin')
                and (string)$datum->destination_port == $request->get('destination')) {
                $newData = [
                    'carrier' => 'XML',
                    'total_price' => round((string)$datum->price_per_container * $request->get('amount'), 2),
                    'currency' => (string)$datum->currency
                ];

                return $newData;
            }
        }
    }

}
