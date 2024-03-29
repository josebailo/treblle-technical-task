<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Http\Controllers\Web\HomeController::class)->name('home');

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

    Route::namespace(App\Http\Controllers\Web\Tokens::class)->group(function () {
        Route::get('tokens', IndexController::class)->name('tokens');
        Route::get('tokens/new', CreateController::class)->name('tokens.create');
        Route::post('tokens', StoreController::class)->name('tokens.store');
        Route::delete('tokens/{token}', DestroyController::class)->name('tokens.destroy');
    });
});
