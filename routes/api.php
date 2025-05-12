<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\Customer\LoginController;
use App\Http\Controllers\Api\Customer\LogoutController;
use App\Http\Controllers\Api\Customer\RatingController;
use App\Http\Controllers\Api\Customer\MyOrderController;
use App\Http\Controllers\Api\Customer\RegisterController;
use App\Http\Controllers\Api\Customer\MyProfileController;

Route::prefix('customer')->group(function () {
    Route::post('register', [RegisterController::class, '__invoke'])->name('customer.register');
    Route::post('login', [LoginController::class, '__invoke'])->name('customer.login');
    Route::post('logout', [LogoutController::class, '__invoke'])->name('customer.logout');
    Route::get('my-orders', [MyOrderController::class, 'index'])->name('customer.my-orders');
    Route::get('my-orders/{snap_token}', [MyOrderController::class, 'show'])->name('customer.my-orders.show');
    Route::get('my-profile', [MyProfileController::class, 'index'])->name('customer.my-profile');
    Route::post('my-profile', [MyProfileController::class, 'update'])->name('customer.my-profile.update');
    Route::post('ratings', [RatingController::class, '__invoke'])->name('customer.ratings');
});

Route::get('sliders', [SliderController::class, '__invoke'])->name('sliders');