<?php

namespace App\Services\PriceService;

use App\Managers\TypeManager;
use App\Models\Currency;
use App\Models\Port;
use App\Models\Price;
use SimpleXMLElement;

class PriceService
{

    public const CARRIER = array('json', 'xml');
    //https://www.php.net/manual/en/language.oop5.constants.php

    public function get($origin, $destination, $amount)
    {
        $model = Price::query()
            ->whereRelation('port_origin', 'iso_code', $origin)
            ->whereRelation('port_destination', 'iso_code', $destination)
            ->orderBy('carrier', 'asc')
            ->get();
        foreach ($model as $element) {
            $element->price_container = round($element->price_container * $amount, 2);
        }
        //$a=new PriceController();

        return $model;
    }

    /**
     * @param $request
     * @return string
     * @throws \Exception
     */
    public function updateXml($dataXml, $extension)
    {
        $xml = new SimpleXMLElement($dataXml);
        foreach ($xml as $element) {
            $origin = (string)$element->origin_port;
            $destination = (string)$element->destination_port;
            $price_container = (string)$element->price_per_container;
            $expiration_date = (string)$element->expiration_date;
            $currency = (string)$element->currency;
            $expiration_date = date_create($expiration_date);

            $model = Price::query()
                ->where('carrier', $extension)
                ->whereRelation('port_origin', 'iso_code', $origin)
                ->whereRelation('port_destination', 'iso_code', $destination)
                ->orderBy('carrier', 'asc')
                ->get();
            dump($expiration_date);
            if ($model->isEmpty()) {
                $data = [
                    'carrier' => $extension,
                    'origin' => Port::query()->where('iso_code', $origin)->value('id'),
                    'destination' => Port::query()->where('iso_code', $destination)->value('id'),
                    'price_container' => $price_container,
                    'expiration_date' => date_format($expiration_date, 'Y-m-d'),
                    'currency_id' => Currency::query()->where('name', $currency)->value('id'),
                ];
                Price::query()->create($data);
                print_r('--------ABSENT---------');
            }
            if ($model->isNotEmpty()) {
                $model->update
                ([
                    'price_container' => $price_container,
                    'expiration_date' => date_format($expiration_date, 'Y-m-d'),
                ]);
                print_r('--------ABSENT---------');
            }
            $caren = [1 => 'USD', 2 => 'EUR', 3 => 'UA'];


            print_r($origin);
            print_r($destination);
            print_r($price_container);
            print_r($expiration_date);
            print_r($currency);

            print_r('--------------');
            //dd('END');
        }


        /*
        $model = Price::query()
            ->whereRelation('port_origin', 'iso_code', $origin)
            ->whereRelation('port_destination', 'iso_code', $destination)
            ->orderBy('carrier', 'asc')
            ->get();
        foreach ($model as $jk) {
            $jk->price_container = round($jk->price_container * $amount, 2);
        }
        return $model;
        */
        return 'kdfjk';
    }


    /**
     * @param $request
     * @return array
     */
    public function getPrice($request): array
    {
        $total=[];
        foreach(self::CARRIER as $value)
        {
            $element=app(TypeManager::class)->driver($value.'carrier')->getJson($request);
            $total[]=$element;
        }

        return $total;
    }

}
