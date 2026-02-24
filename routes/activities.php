<?php

use App\Http\Controllers\activitiesController;
use App\Http\Controllers\ActivitiesPickupLocationController;
Route::get('/activities', [activitiesController::class, 'index']);
Route::get('/activities/property-summary/{id}', [activitiesController::class, 'getPropertySummary']);
Route::get('/packages/{id}', [activitiesController::class, 'Packages']);



// Read (index)
Route::get('/pickup-locations/{property_id}', [ActivitiesPickupLocationController::class, 'index'])->name('pickup_locations.index');
Route::get('/pickup-locations/create', [ActivitiesPickupLocationController::class, 'create'])->name('pickup_locations.create');
Route::post('/pickup-locations', [ActivitiesPickupLocationController::class, 'store'])->name('pickup_locations.store');
Route::get('/pickup-locations/{id}/edit', [ActivitiesPickupLocationController::class, 'edit'])->name('pickup_locations.edit');
Route::put('/pickup-locations/{id}', [ActivitiesPickupLocationController::class, 'update'])->name('pickup_locations.update');
Route::delete('/pickup-locations/{id}', [ActivitiesPickupLocationController::class, 'destroy'])->name('pickup_locations.destroy');
