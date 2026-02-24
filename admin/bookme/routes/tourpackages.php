<?php

use App\Http\Controllers\TourpackagesController;
use App\Http\Controllers\ItineraryController;


Route::get('/tour-packages', [TourpackagesController::class, 'destinations']);

use App\Http\Controllers\TourpackageRequirmentController;


Route::get('requirements/property/{property_id}', [TourpackageRequirmentController::class, 'index'])->name('requirements.index');
Route::get('requirements/create', [TourpackageRequirmentController::class, 'create'])->name('requirements.create');
Route::post('requirements', [TourpackageRequirmentController::class, 'store'])->name('requirements.store');
Route::get('requirements/{id}', [TourpackageRequirmentController::class, 'show'])->name('requirements.show');
Route::get('requirements/{id}/edit', [TourpackageRequirmentController::class, 'edit'])->name('requirements.edit');
Route::put('requirements/{id}', [TourpackageRequirmentController::class, 'update'])->name('requirements.update');
Route::delete('requirements/{id}', [TourpackageRequirmentController::class, 'destroy'])->name('requirements.destroy');


Route::get('itineraries/create/{property_id}', [ItineraryController::class, 'create'])->name('itineraries.create');
Route::post('itineraries', [ItineraryController::class, 'store'])->name('itineraries.store');
Route::get('itineraries', [ItineraryController::class, 'index'])->name('itineraries.index');
Route::get('itineraries/{itinerary}', [ItineraryController::class, 'show'])->name('itineraries.show');
Route::get('itineraries/edit/{property_id}', [ItineraryController::class, 'edit'])->name('itineraries.edit');
Route::put('itineraries/{itinerary}', [ItineraryController::class, 'update'])->name('itineraries.update');
Route::delete('itineraries/{itinerary}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');

