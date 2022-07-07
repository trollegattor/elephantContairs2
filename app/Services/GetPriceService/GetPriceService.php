<?php

namespace App\Services\GetPriceService;


use App\Models\Currency;
use App\Models\Port;
use App\Models\Price;
use Illuminate\Support\Manager;
use \SimpleXMLElement;

class GetPriceService extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config->get('json.default');
    }
}
