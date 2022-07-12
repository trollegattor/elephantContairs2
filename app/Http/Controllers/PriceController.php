<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriceResourceCollection;
use App\Services\PriceService\PriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PriceController extends Controller
{
    /** @var PriceService $priceService */
    public PriceService $priceService;

    /**
     * @param PriceService $priceService
     */
    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * @param $origin
     * @param $destination
     * @param $amount
     * @return JsonResponse
     */
    public function convert($origin, $destination, $amount): JsonResponse
    {
        $request = new Collection(['origin' => $origin, 'destination' => $destination, 'amount' => $amount]);
        $price = $this->priceService->getPrice($request);

        return response()->json($price);
    }
}
