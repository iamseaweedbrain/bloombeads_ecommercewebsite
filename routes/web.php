<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\SettingsController;


Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/checkout-process', [CartController::class, 'processCheckout'])->name('checkout.process');

Route::post('/logout', function () {
    Session::flush();
    return redirect()->route('auth.page');
})->name('logout');



Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::view('/', 'homepage')->name('homepage');

Route::get('/browsecatalog', [ProductController::class, 'index'])->name('browsecatalog');

Route::view('/customize', 'customize')->name('customize');

Route::view('/support', 'support')->name('support');

Route::view('/settings', 'settings')->name('settings');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::view('/payment', 'payment')->name('payment');

Route::get('/dashboard', function () {
    if (Session::has('user')) {
        return view('dashboard');
    }
    return redirect()->route('auth.page');
})->name('dashboard');


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
