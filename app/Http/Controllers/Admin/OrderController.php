<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')
                        ->paginate(15);

        return view('admin.transactions', [
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified order and its items.
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.transaction_details', [
            'order' => $order
        ]);
    }

    /**
     * Update the status of a specific order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,unpaid,failed',
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $newOrderStatus = $request->order_status;

        // --- RESTOCKING LOGIC ---
        
        if ($newOrderStatus == 'cancelled' && $order->order_status != 'cancelled') {
            
            // Load the items and their associated product
            $order->load('items.product');

            foreach ($order->items as $item) {
                // If the product still exists, add its stock back
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        // Update the order
        $order->payment_status = $request->payment_status;
        $order->order_status = $newOrderStatus;
        $order->save();

        return redirect()->route('admin.transactions.show', $order)->with('success', 'Order status has been updated!');
    }
}