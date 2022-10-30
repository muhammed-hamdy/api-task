<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ColorController;
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
// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    // Users Routes
    Route::group(['prefix'=> 'users', 'as' => 'users.'], function() {
        Route::get('/', [UserController::class, 'index'])->middleware(['delay']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show'])->middleware(['delay']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::match(['put', 'patch'], '/{id}', [UserController::class, 'update']);
    });

    Route::group(['prefix'=> 'colors', 'as' => 'colors.'], function() {
        Route::get('/', [ColorController::class, 'index'])->middleware(['delay']);
        Route::post('/', [ColorController::class, 'store']);
        Route::get('/{id}', [ColorController::class, 'show'])->middleware(['delay']);
        Route::delete('/{id}', [ColorController::class, 'destroy']);
        Route::match(['put', 'patch'], '/{id}', [ColorController::class, 'update']);
    });


});
