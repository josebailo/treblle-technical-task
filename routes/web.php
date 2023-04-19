<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia\Inertia::render('Welcome');
});

Route::get('login', function () {
    return Inertia\Inertia::render('Login');
})->middleware('guest');
Route::post('login', App\Http\Controllers\LoginController::class)->name('login');

Route::get('profile', function () {

})->name('profile');
