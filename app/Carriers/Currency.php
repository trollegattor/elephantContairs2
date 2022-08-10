<?php

namespace App\Carriers;

use App\Carriers\Exception\UnKnownCurrencySymbolException;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Currency
{
    /**
     * @param string $currency
     * @return string
     * @throws UnKnownCurrencySymbolException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getCurrency(string $currency): string
    {
        $allCurrency = app()->get('config')->get('currencies');
        try {
            return $allCurrency[$currency];
        } catch (Exception $e) {
            throw new UnKnownCurrencySymbolException("Unknown currency symbol \"$currency\".");
        }
    }
}
