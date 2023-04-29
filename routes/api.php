<?php

use Illuminate\Support\Facades\Route;

Route::post('/signin', App\Http\Controllers\Api\SignIn\PostController::class)->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('signout', App\Http\Controllers\Api\SignIn\DestroyController::class);
});
