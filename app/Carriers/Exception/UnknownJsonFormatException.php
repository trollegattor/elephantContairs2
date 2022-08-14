<?php

namespace App\Carriers\Exception;

use Exception;
use Illuminate\Http\JsonResponse;

class UnknownJsonFormatException extends Exception
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([$this->message]);
    }
}
