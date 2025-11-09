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

class CheckoutController extends Controller
{
    /**
     * Show the payment page
     */
    public function showPaymentPage()
    {
        $total = session('checkout_total', 0);
        $shipping = 10.00;
        $subtotal = $total > 0 ? $total - $shipping : 0;

        if ($total <= 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        return view('payment', [
            'total' => $total,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
        ]);
    }

    public function process(Request $request)
    {
        // 1. Validate the form data
        $validated = $request->validate([
            'total_amount'   => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cod,gcash,maya',
            
            // vvv NEW VALIDATION RULE vvv
            // The receipt is only required if the method is gcash or maya
            'payment_receipt' => [
                Rule::requiredIf(fn () => in_array($request->payment_method, ['gcash', 'maya'])),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048', // 2MB max size
            ],
        ]);

        // 2. Get data from the session
        $itemIdsToCheckout = session('checkout_item_ids', []);
        $total = session('checkout_total', 0);
        $cart = Auth::user()->cart;

        // 3. Check for errors
        if (empty($itemIdsToCheckout) || $total <= 0 || !$cart) {
            return redirect()->route('cart')->with('error', 'Your session expired or your cart is empty. Please try again.');
        }

        // 4. Get items from the DATABASE
        $items = CartItem::where('cart_id', $cart->id)
                           ->whereIn('id', $itemIdsToCheckout)
                           ->with('product')
                           ->get();
        
        if ($items->count() != count($itemIdsToCheckout)) {
             return redirect()->route('cart')->with('error', 'Some items could not be found. Please refresh and try again.');
        }

        // 6. Determine Payment Status
        $paymentStatus = ($validated['payment_method'] === 'cod') ? 'unpaid' : 'pending';

        // 7. Create the Order (Database Transaction)
        DB::beginTransaction();

        try {
            
            // --- vvv NEW: Handle File Upload vvv ---
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                // Store in 'public/receipts' folder
                $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
            }
            // --- ^^^ END OF FILE LOGIC ^^^ ---

            // Create the main Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'order_status' => 'pending',
                'payment_receipt_path' => $receiptPath, // <-- ADDED THIS LINE
            ]);

            // Create User Activity
            UserActivity::create([
                'user_id' => Auth::id(),
                'message' => 'Placed Order #' . $order->order_tracking_id,
                'url' => route('order.show', $order->order_tracking_id)
            ]);

            // 8. Create the Order Items
            foreach ($items as $item) {
                // ... (your existing foreach loop code to create OrderItem, decrement stock, and delete from cart)
                if (!$item->product) {
                    throw new \Exception("Product with ID {$item->product_id} not found.");
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
                $item->delete(); 
            }

            DB::commit();

            session()->forget('checkout_total');
            session()->forget('checkout_item_ids');

            return redirect()->route('checkout.success')->with([
                'success' => 'Your order has been placed!',
                'order_tracking_id' => $order->order_tracking_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
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