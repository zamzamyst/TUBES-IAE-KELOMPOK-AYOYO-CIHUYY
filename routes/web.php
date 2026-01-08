<?php

use App\Http\Controllers\OrderController; 
use App\Http\Controllers\MenuController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DeliveryServiceController;
use App\Http\Controllers\TrackingController;

use Illuminate\Support\Facades\Route;


/* GraphQL Playground Route */
Route::get('/graphql-playground', function () {
    return file_get_contents(public_path('graphql-playground.html'));
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* Routes bawaan untuk Fitur Profil */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*  Routes untuk Fitur Menu  */
    Route::controller(MenuController::class)
    ->prefix('menu')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('menu');
        Route::get('create', 'create')->name('menu.create');
        Route::post('store', 'store')->name('menu.store');
        Route::get('show/{id}', 'show')->name('menu.show');
        Route::get('edit/{id}', 'edit')->name('menu.edit');
        Route::put('edit/{id}', 'update')->name('menu.update');
        Route::delete('destroy/{id}', 'destroy')->name('menu.destroy');
    });

    /*  Routes untuk Fitur Order  */
    Route::controller(OrderController::class)
    ->prefix('order')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('order');
        Route::get('/create/{menu_code}', 'create')->name('order.create');
        Route::post('/store', 'store')->name('order.store');
        Route::get('/show/{id}', 'show')->name('order.show');
        Route::get('/edit/{id}', 'edit')->name('order.edit');
        Route::put('/edit/{id}', 'update')->name('order.update');
        Route::delete('/destroy/{id}', 'destroy')->name('order.destroy');
    });

    /*  Routes untuk Fitur Delivery  */
    Route::controller(DeliveryController::class)
    ->prefix('delivery')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('delivery');
        Route::get('/create/{order_id}', 'create')->name('delivery.create');
        Route::post('/store', 'store')->name('delivery.store');
        Route::get('/show/{id}', 'show')->name('delivery.show');
        Route::get('/edit/{id}', 'edit')->name('delivery.edit');
        Route::put('/edit/{id}', 'update')->name('delivery.update');
        Route::delete('/destroy/{id}', 'destroy')->name('delivery.destroy');
    });

    /*  Routes untuk Fitur Delivery Service (Provider)  */
    Route::controller(DeliveryServiceController::class)
    ->prefix('delivery-service')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('delivery-service');
        Route::get('create', 'create')->name('delivery-service.create');
        Route::post('store', 'store')->name('delivery-service.store');
        Route::get('show/{id}', 'show')->name('delivery-service.show');
        Route::get('edit/{id}', 'edit')->name('delivery-service.edit');
        Route::put('edit/{id}', 'update')->name('delivery-service.update');
        Route::delete('destroy/{id}', 'destroy')->name('delivery-service.destroy');
    });

    /*  Routes untuk Fitur Tracking  */
    Route::controller(TrackingController::class)
    ->prefix('tracking')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('tracking');
        Route::get('/create/{delivery_id}', 'create')->name('tracking.create');
        Route::post('/store', 'store')->name('tracking.store');
        Route::get('/show/{id}', 'show')->name('tracking.show');
        Route::get('/edit/{id}', 'edit')->name('tracking.edit');
        Route::put('/edit/{id}', 'update')->name('tracking.update');
        Route::put('/update-by-delivery/{delivery_id}', 'updateByDelivery')->name('tracking.updateByDelivery');
        Route::delete('/destroy/{id}', 'destroy')->name('tracking.destroy');
    });

    /*  Routes untuk Fitur Feedback  */
    Route::controller(FeedbackController::class)
    ->prefix('feedback')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('feedback');
        Route::get('create/{order_id}', 'create')->name('feedback.create');
        Route::post('store', 'store')->name('feedback.store');
        Route::get('show/{id}', 'show')->name('feedback.show');
        Route::get('edit/{id}', 'edit')->name('feedback.edit');
        Route::put('edit/{id}', 'update')->name('feedback.update');
        Route::delete('destroy/{id}', 'destroy')->name('feedback.destroy');
    });

    /*  Routes untuk Fitur Users  */
    Route::controller(UserController::class)
    ->prefix('user')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', 'index')->name('user');
        Route::get('/create/{menu_code}', 'create')->name('user.create');
        Route::post('/store', 'store')->name('user.store');
        Route::get('/show/{id}', 'show')->name('user.show');
        Route::get('/edit/{id}', 'edit')->name('user.edit');
        Route::put('/edit/{id}', 'update')->name('user.update');
        Route::delete('/destroy/{id}', 'destroy')->name('user.destroy');
    });
    
});

// Untuk mendeteksi routes/api.php
if (file_exists(base_path('routes/api.php'))) {
    require base_path('routes/api.php');
}

require __DIR__.'/auth.php';
