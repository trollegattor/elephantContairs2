<?php

namespace App\Carriers;

class MyCarriers
{
    const XML = 'xml';
    const JSON = 'json';
    const LIST = [
        'JSON' => self::JSON,
        'XML' => self::XML
    ];
    const CURRENCY = ['$' => 'USD'];
}
