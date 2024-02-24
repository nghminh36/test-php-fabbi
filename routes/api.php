<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::group(["middleware" => "api"], function () {
//    Route::get('get-meals', 'MealController@index');
//});
Route::get('get-meals',  [\App\Http\Controllers\MealController::class, 'index']);
Route::get('get-restaurant',  [\App\Http\Controllers\DishController::class, 'getRestaurant']);
Route::get('get-dishes',  [\App\Http\Controllers\DishController::class, 'getDishes']);


