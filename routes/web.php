<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* ===============================
   USER AUTH ROUTES
   =============================== */

Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Logout (User)
Route::post('/logout', function () {
    Session::flush();
    return redirect()->route('auth.page');
})->name('logout');

/* ===============================
   ADMIN AUTH ROUTES
   =============================== */

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/* ===============================
   USER ROUTES
   =============================== */

// Homepage
Route::view('/', 'homepage')->name('homepage');

// Browse Catalog
Route::get('/browsecatalog', [ProductController::class, 'index'])->name('browsecatalog');

// Customize Page
Route::view('/customize', 'customize')->name('customize');

// Support / Help Page
Route::view('/support', 'support')->name('support');

// Cart Page
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Payment Page
Route::view('/payment', 'payment')->name('payment.index');

// User Dashboard (requires session)
Route::get('/dashboard', function () {
    if (Session::has('user')) {
        return view('dashboard');
    }
    return redirect()->route('auth.page');
})->name('dashboard');

/* ===============================
   SETTINGS ROUTES
   =============================== */
   
Route::middleware(['web'])->group(function () {
    Route::view('/settings', 'account_settings.settings')->name('settings.page');
    Route::post('/settings/profile/update', [AuthController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/password/update', [AuthController::class, 'updatePassword'])->name('settings.password.update');
});


/* ===============================
   ADMIN ROUTES (Protected)
   =============================== */
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    // Product Catalog Management
    Route::get('/catalog', [AdminProductController::class, 'index'])->name('catalog.index');
    Route::post('/catalog', [AdminProductController::class, 'store'])->name('catalog.store');
    Route::get('/catalog/{product}/edit', [AdminProductController::class, 'edit'])->name('catalog.edit');
    Route::put('/catalog/{product}', [AdminProductController::class, 'update'])->name('catalog.update');
    Route::delete('/catalog/{product}', [AdminProductController::class, 'destroy'])->name('catalog.destroy');

    // Admin Transactions
    Route::view('/transactions', 'admin.transactions')->name('transactions');

    // Admin Approvals
    Route::view('/approvals', 'admin.approvals')->name('approvals');

    // Admin Notifications
    Route::view('/notifications', 'admin.notifications')->name('notifications');
});
