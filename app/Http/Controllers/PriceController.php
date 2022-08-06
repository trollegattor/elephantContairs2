<?php

namespace App\Http\Controllers;

use App\DTO\DataTransferObject;
use App\Http\Requests\InputDataRequest;
use App\Http\Resources\PriceResourceCollection;
use App\Services\FlipPriceService\Contracts\FlipPriceServiceContract;
use App\Services\PriceService\Contracts\PriceServiceContract;

/**
 *
 */
class PriceController extends Controller
{
    /** @var PriceServiceContract $priceService */
    protected PriceServiceContract $priceService;

    /** @var  FlipPriceServiceContract $flipPriceService */
    protected FlipPriceServiceContract $flipPriceService;

    /**
     * @param PriceServiceContract $priceService
     * @param FlipPriceServiceContract $flipPriceService
     */
    public function __construct(PriceServiceContract $priceService, FlipPriceServiceContract $flipPriceService)
    {
        $this->priceService = $priceService;
        $this->flipPriceService = $flipPriceService;
    }

    /**
     * @param InputDataRequest $request
     * @return PriceResourceCollection
     */
    public function convert(InputDataRequest $request): PriceResourceCollection
    {
        $inputData = new DataTransferObject(
            $request->validated('origin'),
            $request->validated('destination'),
            $request->validated('amount')
        );
        $carriers = $this->priceService->getPrice($inputData);
        $price = $this->flipPriceService->getTotalPrice($carriers, $inputData);

        return new PriceResourceCollection($price);
    }
}
