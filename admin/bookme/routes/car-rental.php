<?php

use App\Http\Controllers\CarPriceController;
use App\Http\Controllers\CarRentalController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarModelController;

Route::get('/car-rental', [CarRentalController::class, 'destinations']);


Route::get('/car-prices/{id}', [CarPriceController::class, 'index'])->name('car-prices.index');
Route::get('/car-prices/create', [CarPriceController::class, 'create'])->name('car-prices.create');
Route::post('/car-prices', [CarPriceController::class, 'store'])->name('car-prices.store');
Route::get('/car-prices/{id}/edit', [CarPriceController::class, 'edit'])->name('car-prices.edit');
Route::put('/car-prices/{id}', [CarPriceController::class, 'update'])->name('car-prices.update');
Route::delete('/car-prices/{id}', [CarPriceController::class, 'destroy'])->name('car-prices.destroy');


Route::resource('car-brands', CarBrandController::class);



Route::get('/car-models/{id}', [CarModelController::class, 'index'])->name('car-models.index');
Route::get('/car-models/create', [CarModelController::class, 'create'])->name('car-models.create');
Route::post('/car-models', [CarModelController::class, 'store'])->name('car-models.store');
Route::get('/car-models/{id}/edit', [CarModelController::class, 'edit'])->name('car-models.edit');
Route::put('/car-models/{id}', [CarModelController::class, 'update'])->name('car-models.update');
Route::delete('/car-models/{id}', [CarModelController::class, 'destroy'])->name('car-models.destroy');



Route::get('/get-models/{brand_id}', [CarModelController::class, 'getModels']);
