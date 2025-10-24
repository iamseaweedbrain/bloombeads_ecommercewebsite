<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
