<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;

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

    /**
     * Handle the checkout form submission and create the order.
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'total_amount'   => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cod,gcash,maya',
        ]);

        $itemIdsToCheckout = session('checkout_item_ids', []);
        $total = session('checkout_total', 0);
        $cart = Auth::user()->cart;

        if (empty($itemIdsToCheckout) || $total <= 0 || !$cart) {
            return redirect()->route('cart')->with('error', 'Your session expired or your cart is empty. Please try again.');
        }

        $items = CartItem::where('cart_id', $cart->id)
                           ->whereIn('id', $itemIdsToCheckout)
                           ->with('product') // Eager load product info
                           ->get();

        if ($items->count() != count($itemIdsToCheckout)) {
             return redirect()->route('cart')->with('error', 'Some items could not be found. Please refresh and try again.');
        }

        $paymentStatus = ($validated['payment_method'] === 'cod') ? 'unpaid' : 'pending';

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'order_status' => 'pending',
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
                ]);
                
                // Find the product and decrease its stock
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

    /**
     * Show the order success/thank you page.
     */
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