<?php

use App\Http\Controllers\Api\AirlineTariffController;
#use App\Http\Controllers\Api\CargoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\EnsureTruckingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

#Route::get('/calculate-rate/{airlineId}', [CargoController::class, 'calculateRate']);


Route::post('/get-airline-tariff', [AirlineTariffController::class, 'getAirlineTariff']);

Route::get('/airport', [AirportController::class, 'airports'])->name('api.airports');

Route::post('/trucking/charge', [EnsureTruckingController::class, 'calculateCharge']);