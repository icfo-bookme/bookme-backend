<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomepageSliderApiController;



Route::get('/homepage/hot-package', [HomepageSliderApiController::class, 'index']);
Route::get('/tour/destinations', [HomepageSliderApiController::class, 'destinations']);
Route::get('/homepage/images', [HomepageSliderApiController::class, 'PropertyImages']);
Route::get('/services', [HomepageSliderApiController::class, 'services']);
