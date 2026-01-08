<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\V1\DeliveryServiceController;
use Illuminate\Support\Facades\Route;


/**
 * VERSIONED API ROUTES
 * Using /api/v1 prefix for all new endpoints
 */
Route::middleware('api')
    ->prefix('api/v1')
    ->group(function () {
        /* Delivery Services API - Provider Module */
        Route::get('/delivery-services', [DeliveryServiceController::class, 'index']);
        Route::get('/delivery-services/{id}', [DeliveryServiceController::class, 'show']);
        Route::post('/delivery-services', [DeliveryServiceController::class, 'store']);
        Route::put('/delivery-services/{id}', [DeliveryServiceController::class, 'update']);
        Route::delete('/delivery-services/{id}', [DeliveryServiceController::class, 'destroy']);
    });


/**
 * LEGACY API ROUTES (v0)
 * Kept for backward compatibility
 */

/*  Routes API untuk Fitur Menu  */
Route::middleware('api')
    ->prefix('api')
    ->group(function () {
        Route::get('/menu', [MenuController::class, 'index']);
        Route::get('/menu/{id}', [MenuController::class, 'show']);
    });


/*  Routes API untuk Fitur Order  */
Route::middleware('api')
    ->prefix('api')
    ->group(function () {
        Route::get('/order', [OrderController::class, 'index']);
        Route::get('/order/{id}', [OrderController::class, 'show']);
    });


/*  Routes API untuk Fitur Delivery (Legacy)  */
Route::middleware('api')
    ->prefix('api')
    ->group(function () {
        Route::get('/delivery', [DeliveryController::class, 'index']);
        Route::get('/delivery/{id}', [DeliveryController::class, 'show']);
        Route::post('/delivery', [DeliveryController::class, 'store']);
        Route::put('/delivery/{id}', [DeliveryController::class, 'update']);
        Route::delete('/delivery/{id}', [DeliveryController::class, 'destroy']);
    });

/*  Routes API untuk Fitur Tracking  */
Route::middleware('api')
    ->prefix('api')
    ->group(function () {
        Route::get('/tracking', [TrackingController::class, 'index']);
        Route::get('/tracking/{id}', [TrackingController::class, 'show']);
        Route::post('/tracking', [TrackingController::class, 'store']);
        Route::put('/tracking/{id}', [TrackingController::class, 'update']);
        Route::put('/tracking/delivery/{delivery_id}', [TrackingController::class, 'updateByDelivery']);
        Route::delete('/tracking/{id}', [TrackingController::class, 'destroy']);
    });

/*  Routes API untuk Fitur Feedback  */
Route::middleware('api')
    ->prefix('api')
    ->group(function () {
        Route::get('/feedback', [FeedbackController::class, 'index']);
        Route::get('/feedback/{id}', [FeedbackController::class, 'show']);
    });

/*  Routes API untuk Fitur Users  */
Route::middleware('api')
    ->prefix('api')
    ->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user/{id}', [UserController::class, 'show']);
    });



