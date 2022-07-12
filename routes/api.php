<?php

use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/quote/rates/{origin}/{destination}/{amount}',[PriceController::class, 'convert']);

