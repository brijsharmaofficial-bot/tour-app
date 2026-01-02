<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CabController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackagePricingDetailController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyDetailController;
use App\Models\City;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/gp', fn () => bcrypt('admin123')); // Dev utility (remove in production)

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by auth + role:admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::resource('company-details', CompanyDetailController::class);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Page Builder (with CKEditor Upload)
    |--------------------------------------------------------------------------
    */
    Route::post('/ckeditor/upload', function (Request $request) {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ckeditor/'), $filename);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => asset('uploads/ckeditor/' . $filename)
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Upload failed'],
        ]);
    })->name('ckeditor.upload');

    Route::resource('pages', PageController::class);

    /*
    |--------------------------------------------------------------------------
    | Cities Management
    |--------------------------------------------------------------------------
    */
    Route::get('/cities/search', function (Request $request) {
        $query = $request->get('q', '');
        $cities = City::where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);
        return response()->json($cities);
    })->name('cities.search');

    Route::resource('cities', CityController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Vehicle Types, Vendors, Cabs
    |--------------------------------------------------------------------------
    */
    Route::resource('vehicle-types', VehicleTypeController::class)->except(['show']);
    Route::resource('vendors', VendorController::class);
    Route::resource('cabs', CabController::class);

    /*
    |--------------------------------------------------------------------------
    | Packages + Pricing Details
    |--------------------------------------------------------------------------
    */
    Route::resource('packages', PackageController::class);

    // Local package pricing (child resource)
    Route::prefix('packages/{package}/pricing')
        ->name('package_pricing.')
        ->group(function () {
            Route::get('/', [PackagePricingDetailController::class, 'index'])->name('index');
            Route::get('/create', [PackagePricingDetailController::class, 'create'])->name('create');
            Route::post('/', [PackagePricingDetailController::class, 'store'])->name('store');
            Route::get('/{detail}/edit', [PackagePricingDetailController::class, 'edit'])->name('edit');
            Route::put('/{detail}', [PackagePricingDetailController::class, 'update'])->name('update');
            Route::delete('/{detail}', [PackagePricingDetailController::class, 'destroy'])->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | Airports, Routes, and Bookings
    |--------------------------------------------------------------------------
    */
    Route::resource('airports', AirportController::class);
    Route::resource('routes', RouteController::class);
    Route::resource('bookings', BookingController::class);

    // Assign vendor/cab to booking
    Route::post('/bookings/{booking}/assign', [BookingController::class, 'assignVendor'])
        ->name('bookings.assign');

    Route::get('/admin/get-distance', [BookingController::class, 'getDistance'])->name('bookings.distance');
    Route::get('/admin/get-cabs', [BookingController::class, 'getCabs'])->name('bookings.cabs');
    Route::get('/admin/get-package', [BookingController::class, 'getPackage'])->name('bookings.package');
    
    Route::get('/admin/packages/search', [BookingController::class, 'search']);
    Route::get('/get-vendor-cabs', [PackageController::class, 'getVendorCabs'])->name('get.vendor.cabs');

    /*
    |--------------------------------------------------------------------------
    | User Management (Admins can manage all users)
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class);

    // Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
   
    // Alternative: Using controller group
    Route::controller(BookingController::class)->prefix('bookings')->group(function () {
        Route::get('/{booking}/invoice', 'invoice')->name('bookings.invoice');
        Route::get('/{booking}/invoice/print', 'printInvoice')->name('bookings.invoice.print');
        Route::get('/{booking}/invoice/download', 'downloadInvoice')->name('bookings.invoice.download');
        Route::post('/{booking}/invoice/email', 'emailInvoice')->name('bookings.invoice.email');
        Route::post('/{booking}/invoice/update', 'updateInvoice')->name('bookings.update-invoice');
        Route::get('/{booking}/invoice/generate-pdf', 'generatePDF')->name('bookings.invoice.generate-pdf');
    });

    // Booking management routes
        Route::prefix('bookings')->group(function () {
            Route::patch('/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
            Route::patch('/{booking}/update-payment-status', [BookingController::class, 'updatePaymentStatus'])->name('bookings.update-payment-status');
            Route::patch('/{booking}/assign-vendor', [BookingController::class, 'assignVendor'])->name('bookings.assign-vendor');
            Route::post('/{booking}/send-notification', [BookingController::class, 'sendNotification'])->name('bookings.send-notification');
        });
});

/*
|--------------------------------------------------------------------------
| Fallback Route (Handles 404 Errors Gracefully)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
