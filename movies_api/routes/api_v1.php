<?php

use App\Http\Controllers\Api\v1\AuthController;
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

Route::apiResource('movies', MoviesController::class)
    ->middleware('api')
    ->except(['create', 'edit']);


Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('movies.rates', MovieRatesController::class)->except(['show', 'create', 'edit']);
    });
