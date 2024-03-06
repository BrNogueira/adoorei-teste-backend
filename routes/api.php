<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//api
Route::apiResource('mobile', MobileController::class);
Route::apiResource('sales', SalesController::class);
//mobile product
Route::get('/mobiles', [MobileController::class, 'index']);
Route::post('/sales/{id}/mobiles', [SalesController::class, 'addMobile']);
//sales
Route::get('/sales', [SalesController::class, 'index']);
Route::post('/sales', [SalesController::class, 'store']);
Route::get('/sales/{id}', [SalesController::class, 'show']);
Route::delete('/sales/{id}', [SalesController::class, 'destroy']);

