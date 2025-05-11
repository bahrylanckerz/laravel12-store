<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\RegisterController;

Route::prefix('customer')->group(function () {
    Route::post('register', [RegisterController::class, '__invoke'])->name('customer.register');
});
