<?php
use App\Http\Controllers\Api\TourpackagesController;

Route::get('/tourpackages/destinations', [TourpackagesController::class, 'gettourdestinations']);
Route::get('/tourpackages/propertySummary/{destination_id}', [TourpackagesController::class, 'propertyList']);
Route::get('/tourpackages/propertydetails/{id}', [TourpackagesController::class, 'propertyDetails']);
Route::get('/tourpackages/properties', [TourpackagesController::class, 'propertyListAll']);
