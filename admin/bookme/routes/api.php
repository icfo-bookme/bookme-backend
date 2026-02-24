<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TourConsultationRequestController;
use App\Http\Controllers\Api\ContactAttributeController;
use App\Http\Controllers\CarouselSliderController;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FooterPolicyController;
use App\Http\Controllers\Api\separateWebController;
use App\Http\Controllers\Api\CartSessionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\CustomerDetailController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::apiResource('customer-details', CustomerDetailController::class);


Route::get('/property', [PropertyController::class, 'create']);
Route::get('/all', [PropertyController::class, 'index']);
Route::apiResource('tour-consultations', TourConsultationRequestController::class);
Route::apiResource('contact-attributes', ContactAttributeController::class);


Route::apiResource('footers', FooterController::class);

Route::get('/booking/package/{id}', [BookingOrderController::class, 'bookingItem']);

Route::apiResource('footer-policies', FooterPolicyController::class);

Route::get('/carousel-slider/destination/{destination_id}', [CarouselSliderController::class, 'getByDestinationId']);


// separate webiste api
Route::get('/schedules/upcoming/{id}', [ScheduleApiController::class, 'getUpcomingSchedules']);
Route::get('/package/description/{id}', [separateWebController::class, 'FoodandDescription']);

// cart session


Route::apiResource('cart-sessions', CartSessionController::class);
Route::get('/customers/search-phone', [CustomerController::class, 'searchByPhone']);
Route::get('/saintmartin/hotels', [HotelController::class, 'success']);

require __DIR__ . '/api/propertySummary.php';
require __DIR__ . '/api/homepage.php';
require __DIR__ . '/api/hotel.php';
require __DIR__ . '/api/tourpackages.php';
require __DIR__ . '/api/activities.php';
require __DIR__ . '/api/car-rental.php';
require __DIR__ . '/api/flight.php';
require __DIR__ . '/api/packages.php';
require __DIR__ . '/api/order.php';










