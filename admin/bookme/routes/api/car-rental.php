
<?php
use App\Http\Controllers\Api\CarController;

// Route::get('/activities/destinations', [CarController::class, 'getactivitiesdestinations']);
Route::get('/car/propertyList/{destination_id}', [CarController::class, 'propertyList']);
Route::get('/car/destinations', [CarController::class, 'getCarRentaldestinations']);
Route::get('/cars', [CarController::class, 'AllCars']);
Route::get('/cars/brand', [CarController::class, 'getCarBrand']);
Route::get('/cars/model', [CarController::class, 'getCarModel']);
