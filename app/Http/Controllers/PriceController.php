<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputDataRequest;
use App\Http\Resources\PriceResourceCollection;
use App\InitialData\InitialDataObject;
use App\Services\PriceService\Contracts\PriceServiceContract;
use App\Services\CarrierService\Contracts\CarriersServiceContract;

/**
 *
 */
class PriceController extends Controller
{
    /**
     * @param CarriersServiceContract $carriersService
     * @param PriceServiceContract $priceService
     */
    public function __construct(protected CarriersServiceContract $carriersService, protected PriceServiceContract $priceService)
    {
    }

    /**
     * @param InputDataRequest $request
     * @return PriceResourceCollection
     */
    public function convert(InputDataRequest $request): PriceResourceCollection
    {
        $carriers = $this->carriersService->getPrice(
            $request->validated('origin'),
            $request->validated('destination')
        );
        $price = $this->priceService->getTotalPrice($carriers, $request->validated('amount'));

        return new PriceResourceCollection($price);
    }
}
