<?php

use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
//Route::apiResources(['json'=>JsonController::class]);
//Route::apiResources(['example'=>ExampleController::class]);
Route::get('/v1/quote/rates/{origin}/{destination}/{amount}',[PriceController::class, 'study']);
Route::get('/v1/quote/rates/update',[PriceController::class, 'updateXml']);
Route::get('/v1/quote/rates/study',[PriceController::class, 'study']);
