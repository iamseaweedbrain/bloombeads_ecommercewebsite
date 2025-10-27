<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\ProductController;


Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Homepage
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');

/// Browse Catalog
    Route::get('/browsecatalog', [ProductController::class, 'index'])
    ->name('browsecatalog');

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
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

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

// --- ADMIN ROUTES ---
Route::middleware('session.user')->prefix('admin')->name('admin.')->group(function () {
    

    // Route name: admin.dashboard
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    // Route name: admin.catalog.index
    Route::get('/catalog', [AdminProductController::class, 'index'])->name('catalog.index');
    
    Route::get('/catalog/{product}/edit', [AdminProductController::class, 'edit'])->name('catalog.edit');
    Route::put('/catalog/{product}', [AdminProductController::class, 'update'])->name('catalog.update');
    Route::delete('/catalog/{product}', [AdminProductController::class, 'destroy'])->name('catalog.destroy');

    //Saving Product
    Route::post('/catalog', [AdminProductController::class, 'store'])->name('catalog.store');

    // Route name: admin.transactions
    Route::get('/transactions', function() {
        return view('admin.transactions');
    })->name('transactions');

    // Route name: admin.approvals
    Route::get('/approvals', function() {
        return view('admin.approvals');
    })->name('approvals');

    // Route name: admin.notifications
    Route::get('/notifications', function() {
        return view('admin.notifications');
    })->name('notifications');

});
