<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstablishmentController;
use Illuminate\Support\Facades\Route;

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

// routes with authentication
//Route::group(['middleware' => ['auth:sanctum']], function () {
    
    //update establishment data and relations (user e address)
    Route::put('establishment/{id}', [EstablishmentController::class, 'update']);
    
    Route::prefix('client')->group(function () {
        Route::get('', [ClientController::class, 'index']);
        Route::put('{id}', [ClientController::class, 'update']);
        Route::delete('{id}', [ClientController::class, 'destroy']);
    });
    
    Route::prefix('business-hour')->group(function () {
        Route::post('', [BusinessHourController::class, 'store']);
        Route::put('{id}', [BusinessHourController::class, 'update']);
        Route::delete('{id}', [BusinessHourController::class, 'destroy']);
    });

    Route::prefix('category')->group(function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::post('', [CategoryController::class, 'store']);
        Route::put('{id}', [CategoryController::class, 'update']);
        Route::delete('{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('daily-pizza-sale-limit')->group(function () {
        Route::post('', [DailyPizzaSaleLimitController::class, 'store']);
        Route::put('{id}', [DailyPizzaSaleLimitController::class, 'update']);
        Route::delete('{id}', [DailyPizzaSaleLimitController::class, 'destroy']);
    });

    Route::prefix('ingredient')->group(function () {
        Route::get('', [IngredientController::class, 'index']);
        Route::post('', [IngredientController::class, 'store']);
        Route::put('{id}', [IngredientController::class, 'update']);
        Route::delete('{id}', [IngredientController::class, 'destroy']);
    });

    Route::prefix('product')->group(function () {
        Route::post('', [ProductController::class, 'store']);
        Route::put('{id}', [ProductController::class, 'update']);
    });

    Route::prefix('promotion')->group(function () {
        Route::get('', [PromotionController::class, 'index']);
        Route::post('', [PromotionController::class, 'store']);
        Route::put('{id}', [PromotionController::class, 'update']);
        Route::delete('{id}', [PromotionController::class, 'destroy']);
    });

    Route::prefix('order')->group(function () {
        Route::get('', [OrderController::class, 'index']);
        Route::post('', [OrderController::class, 'store']);
        Route::put('{id}', [OrderController::class, 'update']);
    });

//});

// Access system
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::prefix('establishment')->group(function () {
    Route::post('', [EstablishmentController::class, 'store']);
    Route::get('', [EstablishmentController::class, 'index']);
});

Route::get('daily-pizza-sale-limit', [DailyPizzaSaleLimitController::class, 'index']);

Route::get('business-hour', [BusinessHourController::class, 'index']);

//create client
Route::post('client', [ClientController::class, 'store']);

Route::get('product', [ProductController::class, 'index']);
