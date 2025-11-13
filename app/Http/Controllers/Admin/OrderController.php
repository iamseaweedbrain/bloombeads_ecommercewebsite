<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Component;
use Illuminate\Support\Facades\Mail; // <-- 1. IMPORT MAIL
use App\Mail\OrderShipped;            // <-- 2. IMPORT THE MAILABLE

class OrderController extends Controller
{
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
        $oldStatus = $order->order_status;
        $paymentMethod = $order->payment_method;

        // --- Validation Logic ---
        if (
            ($newPaymentStatus === 'pending' || $newPaymentStatus === 'failed') &&
            (in_array($newOrderStatus, ['processing', 'shipped', 'delivered']))
        ) {
            return redirect()->back()->with('error', 'You cannot mark an order as Processing, Shipped, or Delivered if the payment is still Pending or has Failed.');
        }
        if (in_array($paymentMethod, ['gcash', 'maya']) && $newPaymentStatus != 'paid') {
            if (in_array($newOrderStatus, ['processing', 'shipped', 'delivered'])) {
                return redirect()->back()->with('error', 'GCash/Maya orders must be "Paid" before they can be Processed, Shipped, or Delivered.');
            }
        }
        
        // Restock logic
        if ($newOrderStatus == 'cancelled' && $oldStatus != 'cancelled') {
            $order->load('items.product'); // Load items to restock
            foreach($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        // Update the order
        $order->payment_status = $newPaymentStatus;
        $order->order_status = $newOrderStatus;
        $order->save();

        // --- vvv 3. SEND "ORDER SHIPPED" EMAIL vvv ---
        // Check if the new status is 'shipped' AND the old status was NOT 'shipped'
        if ($newOrderStatus == 'shipped' && $oldStatus != 'shipped') {
            $order->load('user', 'items.product');
            
            // Use ->send() to send it instantly
            Mail::to($order->user->email)->send(new OrderShipped($order));
        }
        // --- ^^^ END OF EMAIL LOGIC ^^^ ---

        return redirect()->route('admin.transactions')->with('success', "Order #{$order->order_tracking_id} has been updated!");
    }
}