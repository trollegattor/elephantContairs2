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
        /** @var string $default */
        $default = $this->config->get('carrier.carriers.default');

        return $default;
    }

    /**
     * @return JsonCarrier
     */
    public function createJsonCarrierDriver(): JsonCarrier
    {

        return new JsonCarrier();
    }

    /**
     * @return XmlCarrier
     */
    public function createXmlCarrierDriver(): XmlCarrier
    {
        return new XmlCarrier();
    }
}
