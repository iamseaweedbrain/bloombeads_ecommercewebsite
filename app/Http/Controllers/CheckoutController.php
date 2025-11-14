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
use App\Models\CustomDesign;
use App\Models\Component;

class CheckoutController extends Controller
{

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
            // If an order exists, just re-set the session with the SUBTOTAL
            session([
                'checkout_total' => $existingOrder->items->first()->price, // This is the subtotal
                'checkout_order_id' => $existingOrder->id,
            ]);
            return redirect()->route('checkout.payment');
        }

        $shipping = 49.00;
        $subtotal = $design->final_price; // This is the subtotal
        $total_amount = $subtotal + $shipping; // This is the final total

        DB::beginTransaction();
        try {
            // 1. Create the Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'custom_design_id' => $design->id, // Link to the design
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $total_amount, // Save the FULL total to the order
                'payment_method' => null, // Not set yet
                'payment_status' => 'unpaid', // Will be updated on payment page
                'order_status' => 'pending', // Will be updated on payment page
            ]);

            // 2. Create the Order Item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => 21, // Linking to "Custom Beaded Bracelet"
                'quantity' => 1,
                'price' => $subtotal, // Save the subtotal as the price
            ]);

            // 3. Mark the design as 'complete' so it can't be ordered again
            $design->update(['status' => 'complete']);

            // 4. Set session for payment page
            session([
                'checkout_total' => $subtotal, // <-- FIX: Only store the SUBTOTAL
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
        $subtotal = session('checkout_total', 0); // <-- FIX: The session value is the subtotal
        $shipping = ($subtotal > 0) ? 49.00 : 0.00; // <-- FIX: Calculate shipping based on subtotal
        $total = $subtotal + $shipping; // <-- FIX: Calculate the final total

        if ($subtotal <= 0) {
            // Check if it's a custom design order that failed
            if(session('checkout_order_id')) {
                 $order = Order::find(session('checkout_order_id'));
                 if($order) {
                    // Re-fetch the subtotal from the order item
                    $subtotal = $order->items->first()->price ?? 0;
                    $shipping = ($subtotal > 0) ? 49.00 : 0.00;
                    $total = $subtotal + $shipping;
                    session(['checkout_total' => $subtotal]); // Re-set the session
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
        $subtotal = session('checkout_total', 0); // This is the subtotal
        $cart = Auth::user()->cart;

        if (empty($itemIdsToCheckout) || $subtotal <= 0 || !$cart) {
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
        $shipping = ($subtotal > 0) ? 49.00 : 0.00;
        $total_amount = $subtotal + $shipping;

        // Validate that the total_amount from the form matches the calculated total
        if (abs(floatval($validated['total_amount']) - $total_amount) > 0.01) {
            return redirect()->back()->with('error', 'Total amount mismatch. Please try again.');
        }

        DB::beginTransaction();

        try {
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $total_amount, // Save the FULL total
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
                    // 'product_name' => $item->product->name, 
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