<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth; // <-- ADD THIS
use Illuminate\Support\Facades\Session; // <-- Remove this if not used elsewhere

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.header', function ($view) {
            $totalQuantity = 0;
            // Check if a user is logged in
            if (Auth::check()) {
                // Get the user's cart (or create it)
                $cart = Auth::user()->cart()->firstOrCreate();
                // Sum the quantity from the database
                $totalQuantity = $cart->items()->sum('quantity');
            }
            $view->with('cartTotalQuantity', (int)$totalQuantity);
        });
    }
}