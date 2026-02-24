<?php
use App\Http\Controllers\Api\ActivitiesController;

Route::get('/activities/destinations', [ActivitiesController::class, 'getactivitiesdestinations']);
Route::get('/pickup/destinations/{property_id}', [ActivitiesController::class, 'getPickupDestinations']);
Route::get('/activities/propertyList/{destination_id}', [ActivitiesController::class, 'getpropertyList']);

Route::get('/activities', [ActivitiesController::class, 'getactivities']);
Route::get('/related/properties/{destination_id}/{property_id}', [ActivitiesController::class, 'getrelatedproperty']);