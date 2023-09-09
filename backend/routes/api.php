<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessHourController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DailyPizzaSaleLimitController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\IngredientController;
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
        Route::get('', [ClientController::class, 'index']);
        Route::put('{id}', [ClientController::class, 'update']);
        Route::delete('{id}', [ClientController::class, 'destroy']);
    });
    
    // quando tiver autenticação funcionando, colocar a middleware para apenas estabelecimento conseguir fazer alguns request
    // ->middleware('verify.establishment.user')
    Route::prefix('business-hour')->group(function () {
        Route::post('', [BusinessHourController::class, 'store']);
        Route::put('', [BusinessHourController::class, 'update']);
    });

    Route::prefix('category')->group(function () {
        Route::get('all', [CategoryController::class, 'index']);
        Route::get('', [CategoryController::class, 'show']);
        Route::post('', [CategoryController::class, 'store']);
        Route::put('', [CategoryController::class, 'update']);
        Route::delete('', [CategoryController::class, 'destroy']);
    });

    Route::prefix('daily-pizza-sale-limit')->group(function () {
        Route::get('all', [DailyPizzaSaleLimitController::class, 'index']);
        Route::post('', [DailyPizzaSaleLimitController::class, 'store']);
        Route::put('', [DailyPizzaSaleLimitController::class, 'update']);
        Route::delete('', [DailyPizzaSaleLimitController::class, 'destroy']);
    });

    Route::prefix('ingredient')->group(function () {
        Route::get('all', [IngredientController::class, 'index']);
        Route::get('', [IngredientController::class, 'show']);
        Route::post('', [IngredientController::class, 'store']);
        Route::put('', [IngredientController::class, 'update']);
        Route::delete('', [IngredientController::class, 'destroy']);
    });

    Route::prefix('product')->group(function () {
        Route::post('', [ProductController::class, 'store']);
        Route::put('{id}', [ProductController::class, 'update']);
    });

    Route::prefix('promotion')->group(function () {
        Route::get('all', [PromotionController::class, 'index']);
        Route::get('', [PromotionController::class, 'show']);
        Route::post('', [PromotionController::class, 'store']);
        Route::put('', [PromotionController::class, 'update']);
        Route::delete('', [PromotionController::class, 'destroy']);
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

Route::get('daily-pizza-sale-limit/{id}', [DailyPizzaSaleLimitController::class, 'show']);

Route::get('business-hour', [BusinessHourController::class, 'index']);

//create client
Route::post('client', [ClientController::class, 'store']);

Route::get('product', [ProductController::class, 'index']);
