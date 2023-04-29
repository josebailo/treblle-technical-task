<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia\Inertia::render('Welcome');
})->name('home');

Route::namespace(App\Http\Controllers\Web\SignIn::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('signin', CreateController::class)->name('signin');
        Route::post('signin', PostController::class);
    });

    Route::post('signout', DestroyController::class)->name('signout')->middleware('auth');
});

Route::middleware('guest')->namespace(App\Http\Controllers\Web\SignUp::class)->group(function () {
    Route::get('signup', CreateController::class)->name('signup');
    Route::post('signup', PostController::class);
});

Route::middleware('auth')->group(function () {
    Route::namespace(App\Http\Controllers\Web\Profile::class)->group(function () {
        Route::get('profile', EditController::class)->name('profile');
        Route::post('profile', UpdateController::class);
    });

    Route::namespace(App\Http\Controllers\Web\Password::class)->group(function () {
        Route::get('password', EditController::class)->name('password');
        Route::post('password', UpdateController::class);
    });
});
