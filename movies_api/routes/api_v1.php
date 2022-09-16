<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoriesController;
use App\Http\Controllers\Api\v1\MovieRatesController;
use App\Http\Controllers\Api\v1\MoviesController;
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
Route::middleware('api')
    ->prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
    });

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('movies.rates', MovieRatesController::class)
            ->except(['show', 'create', 'edit']);
        Route::apiResource('movies', MoviesController::class)->except(['create', 'edit']);
    });

Route::get('categories', CategoriesController::class)->middleware('api')->name('categories');

Route::fallback(function() {
    return response()->json([
       'status' => 'error',
       'message' => 'Not found',
       'code' => 404,
    ], 404);
});
