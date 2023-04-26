<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia\Inertia::render('Welcome');
})->name('home');

Route::namespace('App\Http\Controllers\Web\Authentication')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', ShowLoginController::class)->name('login');
        Route::post('login', LoginController::class);

        Route::get('register', ShowRegisterController::class)->name('register');
        Route::post('register', RegisterController::class);
    });

    Route::post('logout', LogoutController::class)->name('logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::namespace('App\Http\Controllers\Web\Profile')->group(function () {
        Route::get('profile', EditController::class)->name('profile');
        Route::post('profile', UpdateController::class);
    });

    Route::namespace('App\Http\Controllers\Web\Password')->group(function () {
        Route::get('password', EditController::class)->name('password');
        Route::post('password', UpdateController::class);
    });
});
