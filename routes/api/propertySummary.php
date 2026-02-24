<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\propertySummaryController;
Route::get('/propertySummary/{destination_id}', [propertySummaryController::class, 'apiCreate']);
Route::get('/propertySummary/{category_id}/{destination_id}', [propertySummaryController::class, 'apiCreateForAll']);
Route::get('/propertyImages/{property_id}', [propertySummaryController::class, 'apiForPropertyImages']);
Route::get('/property-summary/{property_id}', [propertySummaryController::class, 'apiForPropertySummary']);
Route::get('/propertyfacilities/{property_id}', [propertySummaryController::class, 'apiForPropertyfacilities']);
Route::get('/propertyUnit/{property_id}', [propertySummaryController::class, 'apiForPropertyUnit']);
Route::get('/popularPropertySummary/{destination_id}', [propertySummaryController::class, 'isPopular']);
Route::get('/countries/visa', [propertySummaryController::class, 'getAllCountry']);
Route::get('/country/{id}', [propertySummaryController::class, 'getCountry']);
Route::get('/countries', [propertySummaryController::class, 'getCountries']);
Route::get('/ships/{id}', [propertySummaryController::class, 'getShipProperties']);
Route::get('/', function () {
    return response()->json(['message' => 'Successfullay added']);
});


Route::get('/propertySummary1', [propertySummaryController::class, 'apiCreate1']);