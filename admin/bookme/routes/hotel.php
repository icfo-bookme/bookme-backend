<?php

use App\Http\Controllers\HotelCategoryController;
use App\Http\Controllers\HotelCountryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FeatureCategoryController;
use App\Http\Controllers\HotelFeatureController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFeatureController;
use App\Http\Controllers\FacilitiesIconController;

use App\Http\Controllers\HotelPolicyController;



Route::resource('feature-categories', FeatureCategoryController::class);
Route::resource('features', FeatureController::class);
Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
Route::get('/get/all/hotels', [HotelController::class, 'getAllHotel'])->name('hotels.getAllHotel');
Route::get('/hotel/{id}', [HotelController::class, 'index'])->middleware('checkPermission:hotel.view');
Route::get('/hotel/create/{id}', [HotelController::class, 'create']);
Route::get('/hotel/edit/{id}', [HotelController::class, 'showEdit']);
Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])->name('hotels.destroy');
Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
Route::put('/status/hotels', [HotelController::class, 'statusUpdate'])->name('hotels.statusUpdate');
Route::post('/hotels/bulk-update', [HotelController::class, 'statusUpdate'])->name('hotels.bulk-update');

Route::resource('facilities-icons', FacilitiesIconController::class);
Route::get('/facility/icons', [FacilitiesIconController::class, 'RoomFacilities']);

Route::resource('hotel_categories', HotelCategoryController::class);

Route::resource('hotel-categories', HotelCategoryController::class);

Route::resource('hoteln/countries', HotelCountryController::class)
    ->names([
        'index' => 'hotel.countries.index',
        'create' => 'hotel.countries.create',
        'store' => 'hotel.countries.store',
        'show' => 'hotel.countries.show',
        'edit' => 'hotel.countries.edit',
        'update' => 'hotel.countries.update',
        'destroy' => 'hotel.countries.destroy'
    ]);
    



Route::get('hotel/features/{id}', [HotelFeatureController::class, 'index'])->name('hotel-features.index');
Route::get('hotel-features/create', [HotelFeatureController::class, 'create'])->name('hotel-features.create');
Route::post('hotel-features', [HotelFeatureController::class, 'store'])->name('hotel_features.store');
Route::get('hotel-features/{id}', [HotelFeatureController::class, 'show'])->name('hotel-features.show');
Route::get('hotel-features/{id}/edit', [HotelFeatureController::class, 'edit'])->name('hotel-features.edit');
Route::put('hotel-features/{id}', [HotelFeatureController::class, 'update'])->name('hotel-features.update');
Route::patch('hotel-features/{id}', [HotelFeatureController::class, 'update']);
Route::delete('hotel-features/{id}', [HotelFeatureController::class, 'destroy'])->name('hotel-features.destroy');


Route::get('room/features/{id}', [RoomFeatureController::class, 'index'])->name('room-features.index');
Route::get('room-features/create', [RoomFeatureController::class, 'create'])->name('room-features.create');
Route::post('room-features', [RoomFeatureController::class, 'store'])->name('room_features.store');
Route::get('room-features/{id}', [RoomFeatureController::class, 'show'])->name('room-features.show');
Route::get('room-features/{id}/edit', [RoomFeatureController::class, 'edit'])->name('room-features.edit');
Route::put('room-features/{id}', [RoomFeatureController::class, 'update'])->name('room-features.update');
Route::patch('room-features/{id}', [RoomFeatureController::class, 'update']);
Route::delete('room-features/{id}', [RoomFeatureController::class, 'destroy'])->name('hotel-features.destroy');


Route::get('room/features-category', [FeatureCategoryController::class, 'roomCategory'])->name('room-features-category.index');
Route::get('rooms/features', [FeatureController::class, 'roomIndex'])->name('room-features.index');
    
    
// Room Routes
Route::prefix('rooms')->group(function () {
    Route::get('/create/{hotel}', [RoomController::class, 'create'])->name('rooms.create');
    Route::get('/{hotel}', [RoomController::class, 'index'])->name('rooms.index');
    Route::post('/store/{hotel}', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/update/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/destroy/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});

// Room Image Routes
Route::delete('/room-images/{image}', [RoomController::class, 'destroyImage'])->name('room-images.destroy');
  Route::resource('room-types', \App\Http\Controllers\RoomTypeController::class);  




Route::get('/hotel-policies/{hotel_id}', [HotelPolicyController::class, 'index'])->name('hotel-policies.index');
Route::post('/hotel-policies', [HotelPolicyController::class, 'store'])->name('hotel-policies.store');
Route::put('/hotel-policies/{hotel_policy}', [HotelPolicyController::class, 'update'])->name('hotel-policies.update');
Route::delete('/hotel-policies/{hotel_policy}', [HotelPolicyController::class, 'destroy'])->name('hotel-policies.destroy');






















    
    
    
    
    