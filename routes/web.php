<?php
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AddFacilityController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\PropertySummaryController;
use App\Http\Controllers\PropertyUnitController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\TourConsultationRequestAdminController;
use App\Http\Controllers\FooterPolicyManagementController;
use App\Http\Controllers\ContactAttributeController;
use App\Http\Controllers\CarouselSliderController;
use App\Http\Controllers\CountryVisaController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomepageSliderController;
use App\Http\Controllers\ImageManagerController;
use App\Http\Controllers\HomepageSectionSettingController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\PropertySummaryTypeController;
use App\Http\Controllers\BookingOrderController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SeoMetaController;
use App\Http\Controllers\FontawesomeIconController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseSubcategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['auth'])->group(function () {
    Route::get('/user-permissions', [UserPermissionController::class, 'index'])->name('user.permissions');
    Route::post('/user-permissions/{id}', [UserPermissionController::class, 'update'])->name('user.permissions.update');

Route::post('/search', [SearchController::class, 'submit'])
    ->name('search.submit');
    
Route::get('/search/{number}', [SearchController::class, 'search'])
    ->name('search.history');


Route::resource('permissions', PermissionsController::class);
Route::resource('receipts', ReceiptController::class);
Route::get('/receipt/search-customers', [ReceiptController::class, 'searchCustomers'])->name('receipts.search-customers');
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/receipt/search-properties', [ReceiptController::class, 'searchProperties'])->name('receipts.search-properties');
Route::get('/receipt/property-units/{propertyId}/{service_id}', [ReceiptController::class, 'getPropertyUnits'])->name('receipts.property-units');

Route::resource('users', UserController::class);
Route::put('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');

Route::get('/notifications', [NotificationController::class, 'index']);
Route::get('/notification/verify/{id}', [NotificationController::class, 'verify'])
    ->name('notification.verify');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('carousel-slider', CarouselSliderController::class);
Route::resource('spots', SpotController::class);
Route::get('/ships', [SpotController::class, 'index'])->middleware('checkPermission:spots.index');
Route::resource('hotel_destinations', DestinationController::class);
Route::get('/hotel', [DestinationController::class, 'index']);
Route::resource('seo', SeoMetaController::class);
Route::resource('country-visas', CountryVisaController::class);
Route::get('/visa', [CountryVisaController::class, 'index'])->middleware('checkPermission:country_visas.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/carousel-slider/destination/{destination_id}', [CarouselSliderController::class, 'index'])->name('carousel-slider.destination');

Route::resource('customers', CustomerController::class);


Route::resource('tour-consultation-requests', TourConsultationRequestAdminController::class);
Route::get('/visa-consultation-requests', [TourConsultationRequestAdminController::class, 'showvisa']);
Route::get('/consultation-requests/{id}', [TourConsultationRequestAdminController::class, 'separateShip']);
Route::put('/consultation-requests/verifyby/{id}', [TourConsultationRequestAdminController::class, 'updateVerifyBy'])
    ->name('consultation.verify-by')
    ->middleware('auth');

Route::get('/services', [ServiceCategoryController::class, 'index']);


Route::get('/fun', [ImageManagerController::class, 'index'])->name('images.index');
Route::post('/images/upload', [ImageManagerController::class, 'upload'])->name('images.upload');
Route::get('/images/delete/{id}', [ImageManagerController::class, 'delete'])->name('images.delete');
Route::get('/houseboat', [SpotController::class, 'houseboat']);

Route::resource('contact-attributes', ContactAttributeController::class);

Route::resource('properties', PropertyController::class);
Route::get('/{category}/properties/{spot_id}', [PropertyController::class, 'spotwiseProperty'])->name('properties.package');
Route::resource('facilities', AddFacilityController::class);
// Route::resource('property_images', PropertyImageController::class);
Route::get('/property_images/{property_id}', [PropertyImageController::class, 'show'])->name('property_images.show');
Route::get('/visa/facilities/{property_id}', [AddFacilityController::class, 'showVisa'])->name('Facility.show');
Route::get('/property-summary/visa/{property_id}', [PropertySummaryController::class, 'showvisa'])->name('viasPropertySummary.show');
Route::get('/property-units/visa/{property_id}', [PropertyUnitController::class, 'showvisa'])->name('viasPropertyUnity.show');
Route::resource('hot-package', HomepageSliderController::class);


Route::resource('homepage-section-settings', HomepageSectionSettingController::class);

Route::post('/property_images', [PropertyImageController::class, 'store'])->name('property_images.store');
Route::delete('/property_images/{image_id}', [PropertyImageController::class, 'destroy'])->name('property_images.destroy');
// Route::resource('AddImages', AddImageController::class);
Route::resource('service_categories', ServiceCategoryController::class);
Route::resource('footer-policies', FooterPolicyManagementController::class);
Route::resource('property-summary', PropertySummaryController::class);
Route::apiResource('property-units', PropertyUnitController::class);
Route::post('/price', [PriceController::class, 'store'])->name('price.store');
Route::resource('discount', DiscountController::class);
Route::resource('item-labels', \App\Http\Controllers\ItemLabelController::class);
Route::resource('fontawesome-icons', FontawesomeIconController::class);

Route::resource('icons', IconController::class);

Route::resource('property-summary-types', PropertySummaryTypeController::class);

Route::get('/schedules/{id}', [ScheduleController::class, 'index'])->name('schedules.index');
Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
Route::get('/schedules/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

// order booking
Route::resource('booking_orders', BookingOrderController::class);
Route::get('/booking/orders', [BookingOrderController::class, 'showOrders']);
// Expense Categories
Route::resource('expense-categories', ExpenseCategoryController::class);

// Expense Subcategories
Route::resource('expense-subcategories', ExpenseSubcategoryController::class);

// Expenses
Route::resource('expenses', ExpenseController::class);



Route::get('/invoice/download/{orderId}', [InvoiceController::class, 'download'])
    ->name('invoice.download');

});

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return '✅ All caches cleared!';
});

Route::get('/test-log', function () {
    \Log::info('Test log entry from cPanel hosting!');
    return 'Check your log file.';
});


// In your routes file (web.php or api.php)

require __DIR__.'/auth.php';
require __DIR__.'/hotel.php';
require __DIR__.'/tourpackages.php';
require __DIR__.'/activities.php';
require __DIR__.'/car-rental.php';
require __DIR__.'/flight.php';

