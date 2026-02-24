<?php

use App\Http\Controllers\Api\BookingOrderController;

Route::prefix('booking-orders')->group(function () {
    Route::get('/', [BookingOrderController::class, 'index']);       
    Route::get('/{id}', [BookingOrderController::class, 'show']);     
    Route::post('/', [BookingOrderController::class, 'store']);  

    Route::put('/{id}', [BookingOrderController::class, 'update']);   
    Route::delete('/{id}', [BookingOrderController::class, 'destroy']); 
});

Route::prefix('AcrivityOrderStore')->group(function () {
    Route::get('/', [BookingOrderController::class, 'index']);       
    Route::get('/{id}', [BookingOrderController::class, 'show']);     
    Route::post('/', [BookingOrderController::class, 'AcrivityOrderStore']);  
    Route::put('/{id}', [BookingOrderController::class, 'update']);   
    Route::delete('/{id}', [BookingOrderController::class, 'destroy']); 
});

Route::get('/check-new-orders', [BookingOrderController::class, 'checkNewOrders']);
Route::get('/hotel/orders/{id}', [BookingOrderController::class, 'showHotelOrder']);


