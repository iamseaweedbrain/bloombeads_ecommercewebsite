<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// ------------------
// HOMEPAGE + GENERAL
// ------------------


Route::get('/', fn() => view('homepage')) ->name('homepage');


Route::get('/browsecatalog', [ProductController::class, 'index'])->name('browsecatalog');
Route::get('/customize', fn() => view('customize'))->name('customize');
Route::get('/support', fn() => view('support'))->name('support');
Route::get('/settings', fn() => view('settings'))->name('settings');
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// ------------------
// AUTH ROUTES
// ------------------
Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::post('/logout', function () {
    session()->forget('user');
    session()->flush();
    return redirect()->route('auth.page');
})->name('logout');

// ------------------
// USER DASHBOARD
// ------------------

/*Route::get('/dashboard', function () {
    return view('dashboard');
});*/



// ------------------
// ACCOUNT ROUTES
// ------------------
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/info', [AccountController::class, 'info'])->name('info');
    Route::get('/activity', [AccountController::class, 'activity'])->name('activity');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
});

// ------------------
// ADMIN ROUTES
// ------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
