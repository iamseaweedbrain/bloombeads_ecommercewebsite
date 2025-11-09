<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // <-- 1. IMPORT THE PRODUCT MODEL

class SupportMessageController extends Controller
{
    public function store(Request $request)
    {
        // ... (your existing store method)
    }

    /**
     * Show the notifications list in the admin panel.
     */
    public function notifications(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = SupportMessage::query();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }
        
        $messages = $query->orderBy('read_at', 'asc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(20)
                         ->withQueryString();

        // --- vvv 2. ADD LOW STOCK QUERY vvv ---
        $lowStockProducts = Product::where('stock', '<=', 5) // Get products with stock 5 or less
                                   ->orderBy('stock', 'asc') // Show lowest stock first
                                   ->get();
        // --- ^^^ END OF NEW QUERY ^^^ ---

        return view('admin.notifications', [
            'messages' => $messages,
            'activeFilter' => $filter,
            'lowStockProducts' => $lowStockProducts // <-- 3. PASS DATA TO THE VIEW
        ]);
    }

    /**
     * Show a single notification message in the admin panel.
     */
    public function show(SupportMessage $message)
    {
        // ... (your existing show method)
    }
}