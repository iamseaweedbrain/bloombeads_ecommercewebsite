<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\UserActivity;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Mail\AdminOrderNotification;
use App\Models\CustomDesign; // <-- 1. ADDED THIS
use App\Models\Component;    // <-- 2. ADDED THIS

class CheckoutController extends Controller
{

    // 3. ADDED THIS ENTIRE NEW FUNCTION
    // This function creates the order *before* sending to payment.
    public function createOrderFromDesign(CustomDesign $design)
    {
        // Check if this design belongs to the logged-in user
        if ($design->user_id !== auth()->id()) {
            abort(404);
        }

        // Check if the design has actually been quoted
        if ($design->status !== 'quoted') {
            return redirect()->route('dashboard', ['tab' => 'designs'])
                             ->with('error', 'This design is not ready for payment.');
        }
        
        // Check if an order already exists for this design
        $existingOrder = Order::where('custom_design_id', $design->id)->first();
        if ($existingOrder) {
            // If an order exists but wasn't paid, just send them to payment
            session([
                'checkout_total' => $existingOrder->total_amount,
                'checkout_order_id' => $existingOrder->id,
            ]);
            return redirect()->route('checkout.payment');
        }

        $shipping = 10.00; // Your shipping fee
        $total = $design->final_price + $shipping;

        DB::beginTransaction();
        try {
            // 1. Create the Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'custom_design_id' => $design->id, // Link to the design
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $total,
                'payment_method' => null, // Not set yet
                'payment_status' => 'unpaid', // Will be updated on payment page
                'order_status' => 'pending', // Will be updated on payment page
            ]);

            // 2. Create the Order Item from the design
            // We need to count the components
            $componentCounts = array_count_values(array_filter($design->design_data));
            $components = Component::find(array_keys($componentCounts));
            $itemDescription = "Custom Bracelet: ";
            foreach ($components as $component) {
                $count = $componentCounts[$component->id];
                $itemDescription .= "{$count}x {$component->name}, ";
            }
            $itemDescription = rtrim($itemDescription, ', ');
            
            // Create a single order item for this custom design
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => null, // No product, it's custom
                'quantity' => 1,
                'price' => $design->final_price,
                'product_name' => 'Custom Beaded Bracelet', // Store the name
                'product_description' => $itemDescription, // Store the components
            ]);

            // 3. Mark the design as 'complete' so it can't be ordered again
            $design->update(['status' => 'complete']);

            // 4. Set session for payment page
            session([
                'checkout_total' => $total,
                'checkout_order_id' => $order->id,
            ]);

            DB::commit();

            // 5. Redirect to the payment page
            return redirect()->route('checkout.payment');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Create Custom Order Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Could not prepare your order.');
        }
    }


    public function showPaymentPage()
    {
        $total = session('checkout_total', 0);
        $shipping = 10.00;
        $subtotal = $total > 0 ? $total - $shipping : 0;

        if ($total <= 0) {
            // Check if it's a custom design order that failed
            if(session('checkout_order_id')) {
                 $order = Order::find(session('checkout_order_id'));
                 if($order) {
                    session(['checkout_total' => $order->total_amount]);
                    $total = $order->total_amount;
                    $subtotal = $total > 0 ? $total - $shipping : 0;
                 } else {
                    return redirect()->route('cart')->with('error', 'Your session expired.');
                 }
            } else {
                 return redirect()->route('cart')->with('error', 'Your cart is empty.');
            }
        }

        return view('payment', [
            'total' => $total,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
        ]);
    }

    public function process(Request $request)
    {
        if ($request->session()->has('checkout_order_id')) {
            return $this->finalizeCustomOrder($request);
        } else {
            return $this->finalizeCartOrder($request);
        }
    }

    private function finalizeCustomOrder(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:cod,gcash,maya',
            'payment_receipt' => [
                Rule::requiredIf(fn () => in_array($request->payment_method, ['gcash', 'maya'])),
                'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048',
            ],
        ]);

        $order = Order::find(session('checkout_order_id'));
        if (!$order) {
            return redirect()->route('cart')->with('error', 'Your session expired. Please try again.');
        }

        DB::beginTransaction();
        try {
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
            }

            $order->update([
                'payment_method' => $validated['payment_method'],
                'payment_status' => ($validated['payment_method'] === 'cod') ? 'unpaid' : 'pending',
                'order_status'   => 'pending', // Set order status to pending
                'payment_receipt_path' => $receiptPath
            ]);
            
            // Create user activity *after* payment is submitted
            UserActivity::create([
                'user_id' => $order->user_id,
                'message' => 'Placed Order #' . $order->order_tracking_id,
                'url' => route('order.show', $order->order_tracking_id)
            ]);

            DB::commit();
            
            $order->load('user', 'items.product');
            
            Mail::to($order->user->email)->send(new OrderPlaced($order));
            Mail::to('reginetuba35@gmail.com')->send(new AdminOrderNotification($order));

            session()->forget('checkout_total');
            session()->forget('checkout_order_id');

            return redirect()->route('checkout.success')->with([
                'success' => 'Your order has been placed!',
                'order_tracking_id' => $order->order_tracking_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Custom Order Finalize Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function finalizeCartOrder(Request $request)
    {
        $validated = $request->validate([
            'total_amount'   => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cod,gcash,maya',
            'payment_receipt' => [
                Rule::requiredIf(fn () => in_array($request->payment_method, ['gcash', 'maya'])),
                'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048',
            ],
        ]);

        $itemIdsToCheckout = session('checkout_item_ids', []);
        $total = session('checkout_total', 0);
        $cart = Auth::user()->cart;

        if (empty($itemIdsToCheckout) || $total <= 0 || !$cart) {
            return redirect()->route('cart')->with('error', 'Your session expired or your cart is empty. Please try again.');
        }

        $items = CartItem::where('cart_id', $cart->id)
                            ->whereIn('id', $itemIdsToCheckout)
                            ->with('product')
                            ->get();
        
        if ($items->count() != count($itemIdsToCheckout)) {
             return redirect()->route('cart')->with('error', 'Some items could not be found. Please refresh and try again.');
        }

        $paymentStatus = ($validated['payment_method'] === 'cod') ? 'unpaid' : 'pending';

        DB::beginTransaction();

        try {
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'order_status' => 'pending',
                'payment_receipt_path' => $receiptPath,
            ]);

            UserActivity::create([
                'user_id' => Auth::id(),
                'message' => 'Placed Order #' . $order->order_tracking_id,
                'url' => route('order.show', $order->order_tracking_id)
            ]);

            foreach ($items as $item) {
                if (!$item->product) {
                    throw new \Exception("Product with ID {$item->product_id} not found.");
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'product_name' => $item->product->name, // Store current name
                ]);
                $item->product->decrement('stock', $item->quantity);
                $item->delete(); 
            }

            DB::commit();

            $order->load('user', 'items.product');
            
            Mail::to($order->user->email)->send(new OrderPlaced($order));
            Mail::to('reginetuba35@gmail.com')->send(new AdminOrderNotification($order));

            session()->forget('checkout_total');
            session()->forget('checkout_item_ids');

            return redirect()->route('checkout.success')->with([
                'success' => 'Your order has been placed!',
                'order_tracking_id' => $order->order_tracking_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Cart Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while placing your order. Please try again.');
        }
    }
    
    public function success()
    {
        if (!session('success') || !session('order_tracking_id')) {
            return redirect()->route('browsecatalog');
        }
        
        return view('checkout.success', [
            'tracking_id' => session('order_tracking_id')
        ]);
    }
}