<?php
namespace App\Managers;


use App\Carriers\JsonCarrier;
use App\Carriers\XmlCarrier;
use Illuminate\Support\Manager;


class TypeManager extends Manager
{
    /**
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return 'jsoncarrier';
    }


    public function createJsonCarrierDriver()
    {
        return new JsonCarrier();
    }

    public function createXmlCarrierDriver()
    {
        return new XmlCarrier();
    }

}
