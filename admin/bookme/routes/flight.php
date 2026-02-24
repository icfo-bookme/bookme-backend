<?php

use App\Http\Controllers\FlightRouteController;

Route::prefix('flight-routes')->name('flight-routes.')->group(function () {
    // Main resource routes
    Route::get('/', [FlightRouteController::class, 'index'])->name('index');
    Route::get('/create', [FlightRouteController::class, 'create'])->name('create');
    Route::post('/', [FlightRouteController::class, 'store'])->name('store');
    Route::get('/{flightRoute}', [FlightRouteController::class, 'show'])->name('show');
    Route::get('/{flightRoute}/edit', [FlightRouteController::class, 'edit'])->name('edit');
    Route::put('/{flightRoute}', [FlightRouteController::class, 'update'])->name('update');
    Route::delete('/{flightRoute}', [FlightRouteController::class, 'destroy'])->name('destroy');
    
    // Additional custom routes if needed
    Route::get('/{flightRoute}/details', [FlightRouteController::class, 'details'])->name('details');
});