<?php

use App\Http\Controllers\Api\PackageController;

Route::get('ship/packages/{id}', [PackageController::class, 'getPackages']);