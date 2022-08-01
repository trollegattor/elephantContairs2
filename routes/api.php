<?php

use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;
Route::prefix('v1/quote/rates')->group(function (){
    Route::get('/{origin}/{destination}/{amount}',[PriceController::class,'convert']);
});


