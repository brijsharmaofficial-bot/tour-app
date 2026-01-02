<?php
use App\Http\Controllers\api\AuthController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PageController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\RouteController;
use App\Http\Controllers\api\CarController;
use App\Http\Controllers\api\SearchCabController;
use App\Http\Controllers\Api\AuthOtpController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\UserController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/pages/{slug}', [PageController::class, 'showBySlug']);

Route::post('/search-cabs', [SearchCabController::class, 'searchCabs']);

Route::post('/cabs/oneway', [SearchCabController::class, 'searchOneWay']);
Route::post('/cabs/roundtrip', [SearchCabController::class, 'searchRoundTrip']);
Route::post('/cabs/local', [SearchCabController::class, 'searchLocal']);
Route::post('/cabs/airport', [SearchCabController::class, 'searchAirport']);

Route::post('/send-otp', [AuthOtpController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthOtpController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthOtpController::class, 'resendOtp']);

Route::post('/booking', [BookingController::class, 'create']);
Route::get('/booking/{id}', [BookingController::class, 'show']);
Route::get('/bookings', [BookingController::class, 'index']);
Route::put('/booking/{id}/status', [BookingController::class, 'updateStatus']);


Route::get('/car-types', [CarController::class, 'VehicleTypes']);
Route::get('/car-options', [CarController::class, 'carOptions']);
Route::get('/car-options-by-cities', [CarController::class, 'cityWiseCarOptions']);

Route::get('/local-car-options', [CarController::class, 'localCarOptions']);
Route::get('/cities', [CityController::class, 'index']);
Route::get('/airport-cities', [CityController::class, 'getAirportCities']);
Route::get('/distance', [RouteController::class, 'getDistance']);

// Protected routes
Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    // Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

         // Current user
    Route::get('/user/me', [UserController::class, 'getCurrentUser']);
    
    // User profile
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    
    // User bookings
    Route::get('/user/{id}/bookings', [UserController::class, 'getUserBookings']);
    
    // Booking actions

    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancelBooking']);
    // Route::post('/user/booking/{id}/pay-remaining', [BookingController::class, 'payRemaining']);
    // Route::post('/user/booking/{id}/complete-payment', [BookingController::class, 'completePaymet']);
    
});