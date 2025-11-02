<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// --- GUEST AND AUTH ROUTES ---
Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Using AuthController logout

// --- ADMIN AUTH ROUTES ---
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// --- PUBLIC PAGES ---
Route::view('/', 'homepage')->name('homepage');
Route::get('/browsecatalog', [ProductController::class, 'index'])->name('browsecatalog');
Route::view('/customize', 'customize')->name('customize');
Route::view('/support', 'support')->name('support');

// --- AUTHENTICATED USER ROUTES ---
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::view('/settings', 'settings')->name('settings');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');

    // Route from Cart to Payment
    Route::post('/cart/proceed-to-payment', [CartController::class, 'proceedToPayment'])->name('cart.proceed');

    // --- CHECKOUT & PAYMENT ROUTES ---
    Route::get('/payment', [CheckoutController::class, 'showPaymentPage'])
         ->name('payment.show');

    Route::post('/checkout/process', [CheckoutController::class, 'process'])
         ->name('checkout.process');

    Route::get('/order/success', [CheckoutController::class, 'success'])
         ->name('checkout.success');
});


// --- ADMIN ROUTES ---
// Using 'session.user' middleware as defined in your stashed file
Route::middleware('session.user')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    // Catalog (Products)
    Route::get('/catalog', [AdminProductController::class, 'index'])->name('catalog.index');
    Route::post('/catalog', [AdminProductController::class, 'store'])->name('catalog.store');
    Route::get('/catalog/{product}/edit', [AdminProductController::class, 'edit'])->name('catalog.edit');
    Route::put('/catalog/{product}', [AdminProductController::class, 'update'])->name('catalog.update');
    Route::delete('/catalog/{product}', [AdminProductController::class, 'destroy'])->name('catalog.destroy');

    // --- TRANSACTION/ORDER ROUTES ---
    Route::get('/transactions', [AdminOrderController::class, 'index'])->name('transactions');
    Route::get('/transactions/{order}', [AdminOrderController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('transactions.update');

    Route::get('/approvals', function() {
        return view('admin.approvals');
    })->name('approvals');

    Route::get('/notifications', function() {
        return view('admin.notifications');
    })->name('notifications');

});
