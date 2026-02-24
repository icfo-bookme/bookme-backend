<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;

Route::delete('/hotelsphotos/{photo}', [HotelController::class, 'destroy']);
Route::delete('/roomsphotos/{photo}', [HotelController::class, 'destroyRoom']);
Route::get('/hotel/destinations', [HotelController::class, 'hotelDestination']);
Route::get('/hotel/listing/{destination_id}', [HotelController::class, 'hotelList']);
Route::get('/hotel/details/{hotel_id}', [HotelController::class, 'hotelDetails']);
Route::get('/hotel/images/{hotel_id}', [HotelController::class, 'hotelImages']);
Route::get('/hotel/rooms/{hotel_id}', [HotelController::class, 'hotelRoom']);
Route::get('/hotel/categories', [HotelController::class, 'hotelCategories']);
Route::get('/hotels', [HotelController::class, 'hotelAll']);
Route::get('/aminities', [HotelController::class, 'getAminities']);
Route::get('/hotels/list/{id}', [HotelController::class, 'hotelListbyid']);