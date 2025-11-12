<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CustomDesign; // <-- 1. IMPORT CustomDesign
use App\Models\UserActivity; // <-- 2. IMPORT UserActivity

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->query('status', 'all');

        // --- Get Orders ---
        $orderQuery = $user->orders()
                           ->with('items.product')
                           ->orderBy('created_at', 'desc');

        switch ($statusFilter) {
            case 'to-pay':
                $orderQuery->whereIn('payment_status', ['pending', 'unpaid'])
                           ->where('order_status', '!=', 'cancelled');
                break;
            case 'to-ship':
                $orderQuery->where('payment_status', 'paid')
                           ->whereIn('order_status', ['pending', 'processing']);
                break;
            case 'to-receive':
                $orderQuery->where('order_status', 'shipped');
                break;
            case 'completed':
                $orderQuery->where('order_status', 'delivered');
                break;
            case 'cancelled':
                $orderQuery->where('order_status', 'cancelled');
                break;
        }
        
        $orders = $orderQuery->paginate(5)->withQueryString();


        // --- Get Recent Activities ---
        $activities = $user->activities()
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
                           
        $customDesigns = $user->customDesigns()
                              ->orderBy('created_at', 'desc')
                              ->get();


        return view('dashboard', [
            'user' => $user,
            'orders' => $orders,
            'activities' => $activities, 
            'customDesigns' => $customDesigns,
            'activeStatusFilter' => $statusFilter
        ]);
    }

    /**
     * Show the details for a single order.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $order->load('user', 'items.product');

        return view('order_details', [
            'order' => $order
        ]);
    }
}