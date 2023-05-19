<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

if (app()->environment('production')) {
    Route::middleware('guest')->group(function () {
        Route::get('/auth/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle']);
        Route::get('/auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleLoginCallback']);
    });

    Route::get('/auth/login', fn () => redirect('/auth/google'))->name('login');
} else {
    // Create a simple login route for local development.
    Route::get('/auth/login', function () {
        Auth::login(User::factory()->create());

        return redirect('/');
    })->name('login');
}

Route::get('/login', fn () => redirect('/auth/login'))->name('login-redirect');
Route::get('/{hash}', App\Http\Controllers\LinkController::class)->name('link');
Route::get('/', App\Http\Controllers\HomeController::class)->name('home');
