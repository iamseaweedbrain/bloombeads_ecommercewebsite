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

        $newPaymentStatus = $request->payment_status;
        $newOrderStatus = $request->order_status;
        $paymentMethod = $order->payment_method; // Get the order's payment method

        // --- vvv NEW VALIDATION LOGIC vvv ---

        // RULE 1: If payment is Failed, order MUST be Cancelled.
        if ($newPaymentStatus == 'failed' && $newOrderStatus != 'cancelled') {
            return redirect()->back()->with('error', 'If Payment Status is "Failed", Order Status must be set to "Cancelled".');
        }

        // RULE 2: If payment is set to Failed, force Order Status to Cancelled
        if ($newPaymentStatus == 'failed') {
            $newOrderStatus = 'cancelled';
        }

        // RULE 3: If method is GCash/Maya, payment MUST be 'paid' to process/ship/deliver.
        if (in_array($paymentMethod, ['gcash', 'maya']) && $newPaymentStatus != 'paid') {
            if (in_array($newOrderStatus, ['processing', 'shipped', 'delivered'])) {
                return redirect()->back()->with('error', 'GCash/Maya orders must be "Paid" before they can be Processed, Shipped, or Delivered.');
            }
        }
        
        // (Note: COD orders are automatically allowed, because $paymentMethod is 'cod',
        // so the rule above is skipped. They can be 'unpaid' and 'shipped'.)

        // --- ^^^ END OF NEW LOGIC ^^^ ---


        // Restock Logic: Check if status is being set to 'cancelled'
        if ($newOrderStatus == 'cancelled' && $order->order_status != 'cancelled') {
            
            $order->load('items.product');

            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        // Update the order
        $order->payment_status = $newPaymentStatus;
        $order->order_status = $newOrderStatus;
        $order->save();

        // --- vvv NEW REDIRECT vvv ---
        // Redirect back to the main transactions list page
        return redirect()->route('admin.transactions')->with('success', "Order #{$order->order_tracking_id} has been updated!");
    }
}