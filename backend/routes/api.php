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
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    //update establishment data and relations (user e address)
    Route::prefix('establishments')->middleware('verify.establishment.user')->group(function () {
        Route::post('', [EstablishmentController::class, 'store']);
        Route::put('/basic-data/{id}', [EstablishmentController::class, 'update']);
        Route::put('/address/{id}', [EstablishmentController::class, 'updateAddress']);
        Route::put('/about/{id}', [EstablishmentController::class, 'updateAbout']);

    });
    
    Route::prefix('clients')->group(function () {
        Route::get('{id}', [ClientController::class, 'show']);
        Route::put('{id}', [ClientController::class, 'update']);
    });
    
    Route::prefix('business-hours')->middleware('verify.establishment.user')->group(function () {
        Route::post('', [BusinessHourController::class, 'store']);
        Route::put('{id}', [BusinessHourController::class, 'update']);
    });

    Route::prefix('categories')->middleware('verify.establishment.user')->group(function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::get('{id}', [CategoryController::class, 'show']);
        Route::post('', [CategoryController::class, 'store']);
        Route::put('{id}', [CategoryController::class, 'update']);
        Route::delete('{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('daily-pizza-sale-limits')->middleware('verify.establishment.user')->group(function () {
        Route::get('', [DailyPizzaSaleLimitController::class, 'index']);
        Route::post('', [DailyPizzaSaleLimitController::class, 'store']);
        Route::put('{id}', [DailyPizzaSaleLimitController::class, 'update']);
        Route::delete('{id}', [DailyPizzaSaleLimitController::class, 'destroy']);
    });

    Route::prefix('ingredients')->middleware('verify.establishment.user')->group(function () {
        Route::get('', [IngredientController::class, 'index']);
        Route::get('{id}', [IngredientController::class, 'show']);
        Route::post('', [IngredientController::class, 'store']);
        Route::put('{id}', [IngredientController::class, 'update']);
        Route::delete('{id}', [IngredientController::class, 'destroy']);
    });

    Route::prefix('products')->middleware('verify.establishment.user')->group(function () {
        Route::post('', [ProductController::class, 'store']);
        Route::put('{id}', [ProductController::class, 'update']);
    });

    Route::prefix('promotions')->middleware('verify.establishment.user')->group(function () {
        Route::get('', [PromotionController::class, 'index']);
        Route::get('{id}', [PromotionController::class, 'show']);
        Route::post('', [PromotionController::class, 'store']);
        Route::put('{id}', [PromotionController::class, 'update']);
        Route::delete('{id}', [PromotionController::class, 'destroy']);
    });

    Route::prefix('orders')->group(function () {
        Route::get('', [OrderController::class, 'index'])->middleware('verify.establishment.user');
        Route::get('{id}', [OrderController::class, 'show'])->middleware('verify.establishment.user');
        Route::post('', [OrderController::class, 'store']);
        Route::put('{id}', [OrderController::class, 'update'])->middleware('verify.establishment.user');
    });

});

// Access system
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::prefix('establishments')->group(function () {
    Route::get('', [EstablishmentController::class, 'index']);
    Route::get('contact', [EstablishmentController::class, 'getContact']);
});

Route::get('daily-pizza-sale-limits/{id}', [DailyPizzaSaleLimitController::class, 'show']);

Route::get('business-hours', [BusinessHourController::class, 'index']);

//create client
Route::post('clients', [ClientController::class, 'store']);

Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'show']);
});
