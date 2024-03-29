<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('signout', App\Http\Controllers\Api\SignIn\DestroyController::class);

    Route::post('profile', App\Http\Controllers\Api\Profile\UpdateController::class);

    Route::post('password', App\Http\Controllers\Api\Password\UpdateController::class);

    Route::namespace(App\Http\Controllers\Api\Tokens::class)->group(function () {
        Route::get('tokens', IndexController::class);
        Route::post('tokens', StoreController::class);
        Route::delete('tokens/{token}', DestroyController::class);
    });
});

Route::middleware('guest')->group(function () {
    Route::post('signin', App\Http\Controllers\Api\SignIn\PostController::class);

    Route::post('signup', App\Http\Controllers\Api\SignUp\PostController::class);
});
