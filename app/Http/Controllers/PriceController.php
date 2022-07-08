<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriceResourceCollection;
use App\Services\PriceService\PriceService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PriceController extends Controller
{
    //'Дам подсказку, хотя нельзя, посмотри на Manager паттерн с Drivers'
    /** @var PriceService $priceService */
    public PriceService $priceService;

    /**
     * @param PriceService $priceService
     */
    public function __construct(PriceService $priceService)
    {
        $this->priceService=$priceService;
    }

    /**
     * @param $origin
     * @param $destination
     * @param $amount
     * @param PriceService $priceService
     * @return PriceResourceCollection
     */
    public function get( $origin, $destination,$amount): PriceResourceCollection
    {
        $price=$this->priceService->get($origin, $destination,$amount);

        return new PriceResourceCollection($price);
    }

    public function updateXml()
    {
        $dataXml=Storage::get('carrier-xml.xml');
        $extension=File::extension('carrier-xml.xml');
        //$a=$request->all();
        //dd($a);

        $update=$this->priceService->updateXml($dataXml,$extension);

        return $update;
    }
    public function updateJson()
    {
        $dataJson=Storage::get('carrier-json.json');
        $dataXml=Storage::get('carrier-xml.xml');
        $a=File::extension('carrier-xml.xml');
        //$a=$request->all();
        dd($a);

        $update=$this->priceService->update($dataJson,$dataXml);

        return $update;
    }
    public function study($origin, $destination,$amount)
    {
        $request= new Collection(['origin'=>$origin,'destination'=> $destination,'amount'=>$amount]);


        $price=$this->priceService->getPrice($request);
        //dd($price);


        //$a=$typeManager->JsonCarrier();
        //dump([$price]);




       return response()->json($price);


    }

}
