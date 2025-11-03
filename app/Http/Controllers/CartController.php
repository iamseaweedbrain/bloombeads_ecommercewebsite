<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Get the user's cart, or create one if it doesn't exist.
     */
    private function getCart()
    {
        $user = Auth::user();
        // Find cart or create a new one for the logged-in user
        $cart = $user->cart()->firstOrCreate();
        return $cart;
    }

    /**
     * Display the cart page with items from the database.
     */
    public function index()
    {
        $cart = $this->getCart();
        // Load the items and their related product data
        $cartItems = $cart->items()->with('product')->get();
        
        $formattedItems = $cartItems->map(function($item) {
            if (!$item->product) {
                return null; 
            }
            return [
                'id' => $item->product->id,
                'cart_item_id' => $item->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'image_path' => $item->product->image_path,
                'category' => $item->product->category
            ];
        })->filter();
        return view('cart', ['cartItems' => $formattedItems]);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Check if item is already in cart
        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            // Update quantity
            $item->quantity += $quantity;
            $item->save();
        } else {
            // Add new item
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        $totalQuantity = $cart->items()->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'totalQuantity' => $totalQuantity
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id', 
        ]);

        $cart = $this->getCart();
        $cartItemId = $request->input('cart_item_id');

        $item = $cart->items()->where('id', $cartItemId)->first();

        if ($item) {
            $item->delete();
        }

        $totalQuantity = $cart->items()->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'totalQuantity' => $totalQuantity
        ]);
    }
    
    /**
     * Update the quantity of an item in the cart.
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();
        $cartItemId = $request->cart_item_id;
        $quantity = $request->quantity;

        // Find the item *in this user's cart*
        $item = $cart->items()->where('id', $cartItemId)->first();

        if ($item) {
            // Update the quantity
            $item->quantity = $quantity;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart.'
        ], 404);
    }

    /**
     * Handle proceeding to the payment page.
     */
    public function proceedToPayment(Request $request)
    {
        // Get the list of selected cart_item_ids from the form
        $selectedItemIds = json_decode($request->input('selected_items', '[]'));

        if (empty($selectedItemIds)) {
            return redirect()->route('cart')->with('error', 'Please select at least one item to check out.');
        }

        $cart = $this->getCart();

        // Get the selected items *from this user's cart*
        $itemsToCheckout = $cart->items()
                                ->with('product')
                                ->whereIn('id', $selectedItemIds)
                                ->get();

        if ($itemsToCheckout->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Selected items not found in your cart.');
        }

        // --- SECURE TOTAL CALCULATION ---
        $subtotal = 0;
        foreach ($itemsToCheckout as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }
        
        $shipping = 10.00;
        $total = $subtotal + $shipping;

        if ($total <= 0) {
            return redirect()->route('cart')->with('error', 'Nothing to check out.');
        }

        session([
            'checkout_total' => $total,
            'checkout_item_ids' => $itemsToCheckout->pluck('id')->toArray()
        ]);

        // Redirect to the payment page
        return redirect()->route('payment.show');
    }


    public function processCheckout(Request $request)
    {
        return redirect()->route('cart');
    }
}