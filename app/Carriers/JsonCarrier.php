<?php
namespace App\Carriers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JsonCarrier
{
    /**
     * @param $request
     * @return array
     */
    public function getJson($request): array
    {
        $data=Storage::get('carrier-json.json');
        $validator=Validator::make(['array'=>$data],['array'=>'json']);
        if($validator->fails())
        {
            return ['Error, file - '.MyCarriers::JSON];
        }
        $data=json_decode($data);
        foreach ($data as $datum)
        {
            if (Str::upper($datum->origin)==$request->get('origin')
                and Str::upper($datum->destination)==$request->get('destination'))
            {
                if($datum->max_date <= (new Carbon())->getTimestamp())
                {
                    return ['Data is out of date, please update the carrier - '.MyCarriers::JSON];
                }
                $newData=[
                    'carrier'=>Str::upper(MyCarriers::JSON),
                    'total_price'=>round($datum->price_per_container*$request->get('amount'),2),
                    'currency'=>MyCarriers::CURRENCY[$datum->currency],
                ];

                return $newData;
            }
        }
        return ['Error, port missing'];
    }
}
