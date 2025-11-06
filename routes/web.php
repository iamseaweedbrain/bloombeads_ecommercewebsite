<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ForgotPasswordOtpController;


Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/forgot-password-otp', [ForgotPasswordOtpController::class, 'requestOtp'])->name('requestOtp');
Route::post('/verify-otp', [ForgotPasswordOtpController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('/reset-password-with-otp', [ForgotPasswordOtpController::class, 'resetPassword'])->name('resetPassword');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::view('/', 'homepage')->name('homepage');
Route::get('/browsecatalog', [ProductController::class, 'index'])->name('browsecatalog');
Route::view('/customize', 'customize')->name('customize');
Route::view('/support', 'support')->name('support');
Route::view('/settings', 'settings')->name('settings');
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// ------------------
// AUTH ROUTES
// ------------------
Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth.page');
Route::post('/auth/signup', [AuthController::class, 'signUp'])->name('auth.signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Optional session logout if needed
Route::post('/logout', function () {
    session()->forget('user');
    session()->flush();
    return redirect()->route('auth.page');
})->name('logout');

// ------------------
// ACCOUNT ROUTES (Your Dashboard)
// ------------------
Route::prefix('account')->name('account.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/info', [AccountController::class, 'info'])->name('info');
    Route::get('/activity', [AccountController::class, 'activity'])->name('activity');
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
});

// ------------------
// CART & CHECKOUT
// ------------------
Route::middleware('auth')->group(function () {
    // Cart routes
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::post('/cart/proceed-to-payment', [CartController::class, 'proceedToPayment'])->name('cart.proceed');

    // Checkout & payment
    Route::get('/payment', [CheckoutController::class, 'showPaymentPage'])->name('payment.show');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// ------------------
// ADMIN ROUTES
// ------------------
Route::middleware('session.user')->prefix('admin')->name('admin.')->group(function () {

    // Admin login/logout
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin dashboard
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

    // Approvals & Notifications
    Route::get('/approvals', function() {
        return view('admin.approvals');
    })->name('approvals');

    Route::get('/notifications', function() {
        return view('admin.notifications');
    })->name('notifications');
});
