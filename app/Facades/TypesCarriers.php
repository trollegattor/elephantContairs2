<?php
namespace App\Facades;

use App\Managers\TypeManager;
use Illuminate\Support\Facades\Facade;

class TypesCarriers extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return TypeManager::class;
    }
}
