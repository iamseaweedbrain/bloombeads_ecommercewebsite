<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Session;


Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Homepage
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');

// Browse Catalog
Route::get('/browsecatalog', function () {
    return view('browsecatalog');
})->name('browsecatalog');

// Customize Page
Route::get('/customize', function () {
    return view('customize');
})->name('customize');

// Support / Help Page
Route::get('/support', function () {
    return view('support');
})->name('support');

// Settings Page
Route::get('/settings', function () {
    return view('settings');
})->name('settings');

// Cart Page
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// User Dashboard
Route::get('/dashboard', function () {
    if (Session::has('user')) {
        return view('dashboard');
    }
    return redirect()->route('auth.page');
})->name('dashboard');

// Logout
Route::post('/logout', function () {
    session()->forget('user');
    session()->flush();
    return redirect()->route('auth.page');
})->name('logout');

// Payment
Route::get('/payment', function () {
    return view('payment');
})->name('payment');





