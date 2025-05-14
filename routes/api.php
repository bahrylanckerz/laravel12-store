<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
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
Route::get('categories', [CategoryController::class, 'index'])->name('categories');
Route::get('categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('products', [ProductController::class, 'index'])->name('products');
Route::get('products-popular', [ProductController::class, 'productpopular'])->name('products.popular');
Route::get('products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('carts', [CartController::class, 'index'])->name('carts');
Route::post('carts', [CartController::class, 'store'])->name('carts.store');
Route::post('carts/increment', [CartController::class, 'increment'])->name('carts.increment');
Route::post('carts/decrement', [CartController::class, 'decrement'])->name('carts.decrement');
Route::delete('carts/destroy/{id}', [CartController::class, 'destroy'])->name('carts.destroy');
Route::delete('carts/destroy-all', [CartController::class, 'destroyAll'])->name('carts.destroy-all');