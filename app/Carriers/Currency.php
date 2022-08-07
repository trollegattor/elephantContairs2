<?php

namespace App\Carriers;

use App\Carriers\Exception\CurrencyError;
use App\Carriers\Exception\UnKnownCurrencySymbolException;
use Exception;
use Throwable;

class Currency
{
    /**
     * @param string $currency
     * @return string
     * @throws UnKnownCurrencySymbolException
     */
    public static function getCurrency(string $currency): string
    {
        $allCurrency=app()->get('config')->get('currencies');
        try {
            return $allCurrency[$currency];
        }
        catch (Exception $e)
        {
            throw new UnKnownCurrencySymbolException("Unknown currency symbol \"$currency\".");
        }
    }
}
