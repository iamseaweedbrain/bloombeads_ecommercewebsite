<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD

Route::get('/', function () {
    return view('welcome');
});

// Temporary preview dashboard route (no DB, no auth) — remove later
Route::get('/account/dashboard-preview', function () {
    $user = (object)[
        'name' => 'Sarah Johnson',
        'email' => 'sarah.johnson@email.com',
        'contact_number' => '+1 (555) 123-4567',
        'address' => "123 Blossom Street, Apt 4B\nNew York, NY 10001\nUnited States",
        'payment' => 'Visa ending in 4242',
    ];

    $orders = [
        (object)['id' => '#ORD-2024-001', 'date'=>'January 15, 2024', 'total'=>'₱1,080.00', 'status'=>'Delivered'],
        (object)['id' => '#ORD-2024-002', 'date'=>'January 10, 2024', 'total'=>'₱998.00', 'status'=>'Delivered'],
        (object)['id' => '#ORD-2023-156', 'date'=>'December 28, 2023', 'total'=>'₱865.00', 'status'=>'Delivered'],
    ];

    $activities = [
        (object)['action'=>'Saved new Custom Bracelet Design: “Moonlit Dragon”','timestamp'=>'1 hour ago'],
        (object)['action'=>'Placed Order #BB1025–001 (₱980.00)','timestamp'=>'Yesterday'],
        (object)['action'=>'Viewed product: Kawaii Jewelry Box','timestamp'=>'3 days ago'],
    ];

    return view('accounts.dashboard_preview', compact('user','orders','activities'));


});

=======
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
>>>>>>> main

/*Route::get('/dashboard', function () {
    return view('dashboard');
<<<<<<< HEAD
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
=======
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
>>>>>>> main
