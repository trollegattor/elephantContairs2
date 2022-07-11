<?php

namespace App\Carriers;

use App\Rules\XmlRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class XmlCarrier
{
    /**
     * @param $request
     * @return array
     */
    public function getJson($request): array
    {
        $data = Storage::get('carrier-xml.xml');
        $validator=Validator::make(['array'=>$data],['array'=> new XmlRule]);
        if($validator->fails())
        {
            return ['Error, file - '.MyCarriers::XML];
        }
        $data=simplexml_load_string($data);
        foreach ($data as $datum) {
            if ((string)$datum->origin_port == $request->get('origin')
                and (string)$datum->destination_port == $request->get('destination'))
            {
                if (Carbon::parse($datum->expiration_date)->getTimestamp()<=(new Carbon())->getTimestamp())
                {
                    return ['Data is out of date, please update the carrier - '.MyCarriers::XML];
                }
                $newData = [
                    'carrier' => Str::upper(MyCarriers::XML),
                    'total_price' => round((string)$datum->price_per_container * $request->get('amount'), 2),
                    'currency' => (string)$datum->currency
                ];
                return $newData;
            }
        }
        return ['Error, port missing'];
    }
}
