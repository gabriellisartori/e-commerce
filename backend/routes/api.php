<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessHourController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DailyPizzaSaleLimitController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
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
    Route::put('establishment', [EstablishmentController::class, 'update']);
    
    Route::prefix('client')->group(function () {
        Route::get('{id}', [ClientController::class, 'show']);
        Route::put('', [ClientController::class, 'update']);
    });
    
    // quando tiver autenticação funcionando, colocar a middleware para apenas estabelecimento conseguir fazer alguns request
    // ->middleware('verify.establishment.user')
    Route::prefix('business-hour')->group(function () {
        Route::post('', [BusinessHourController::class, 'store']);
        Route::put('', [BusinessHourController::class, 'update']);
    });

    Route::prefix('category')->group(function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::get('{id}', [CategoryController::class, 'show']);
        Route::post('', [CategoryController::class, 'store']);
        Route::put('', [CategoryController::class, 'update']);
        Route::delete('{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('daily-pizza-sale-limit')->group(function () {
        Route::get('', [DailyPizzaSaleLimitController::class, 'index']);
        Route::post('', [DailyPizzaSaleLimitController::class, 'store']);
        Route::put('', [DailyPizzaSaleLimitController::class, 'update']);
        Route::delete('{id}', [DailyPizzaSaleLimitController::class, 'destroy']);
    });

    Route::prefix('ingredient')->group(function () {
        Route::get('', [IngredientController::class, 'index']);
        Route::get('{id}', [IngredientController::class, 'show']);
        Route::post('', [IngredientController::class, 'store']);
        Route::put('', [IngredientController::class, 'update']);
        Route::delete('{id}', [IngredientController::class, 'destroy']);
    });

    Route::prefix('product')->group(function () {
        Route::post('', [ProductController::class, 'store']);
        Route::put('', [ProductController::class, 'update']);
    });

    Route::prefix('promotion')->group(function () {
        Route::get('', [PromotionController::class, 'index']);
        Route::get('{id}', [PromotionController::class, 'show']);
        Route::post('', [PromotionController::class, 'store']);
        Route::put('', [PromotionController::class, 'update']);
        Route::delete('{id}', [PromotionController::class, 'destroy']);
    });

    Route::prefix('order')->group(function () {
        Route::get('', [OrderController::class, 'index']);
        Route::get('{id}', [OrderController::class, 'show']);
        Route::post('', [OrderController::class, 'store']);
        Route::put('', [OrderController::class, 'update']);
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

Route::get('daily-pizza-sale-limit/{id}', [DailyPizzaSaleLimitController::class, 'show']);

Route::get('business-hour', [BusinessHourController::class, 'index']);

//create client
Route::post('client', [ClientController::class, 'store']);

Route::prefix('product')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'show']);
});
