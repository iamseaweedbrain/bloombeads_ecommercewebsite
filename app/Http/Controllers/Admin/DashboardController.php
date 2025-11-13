<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Revenue Card
        // Sums all orders that are marked as 'paid' (e.g., GCash) or 'unpaid' (e.g., COD)
        // but are not 'cancelled' or 'failed'.
        $totalRevenue = Order::whereIn('payment_status', ['paid', 'unpaid'])
                             ->where('order_status', '!=', 'cancelled')
                             ->sum('total_amount');

        // 2. New Orders Card
        $newOrders = Order::where('order_status', 'pending')->count();

        // 3. Total Users Card
        $totalUsers = User::count();
        
        // 4. Pending Approvals (for Custom Designs)
        $pendingApprovals = DB::table('custom_designs')
                                ->where('status', 'pending')
                                ->count();

        // 5. Sales Over Time Chart (Last 7 days)
        // Gets paid orders from the last 7 days and groups them by date
        $salesData = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            ]);

        $salesLabels = $salesData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('D'); // Mon, Tue, Wed
        });
        $salesValues = $salesData->pluck('total');

        // 6. Top Products Chart
        // Counts how many times each product appears in *delivered* orders
        $topProductsData = OrderItem::select('product_id', DB::raw('SUM(quantity) as count'))
            ->whereHas('order', function($query) {
                $query->where('order_status', 'delivered');
            })
            ->groupBy('product_id')
            ->orderBy('count', 'DESC')
            ->take(4) // Get top 4
            ->with('product') // Eager load product info
            ->get();
            
        $topProductsLabels = $topProductsData->pluck('product.name');
        $topProductsValues = $topProductsData->pluck('count');


        return view('admin.dashboard', compact(
            'totalRevenue',
            'newOrders',
            'totalUsers',
            'pendingApprovals',
            'salesLabels',
            'salesValues',
            'topProductsLabels',
            'topProductsValues'
        ));
    }
}