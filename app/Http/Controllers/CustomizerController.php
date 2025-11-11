<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComponentCategory;
use App\Models\CustomDesign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Component;
use App\Models\UserActivity;
use Illuminate\Support\Str;

class CustomizerController extends Controller
{
    public function index()
    {
        $categories = ComponentCategory::with(['components' => function ($query) {
            $query->where('stock', '>', 0);
        }])
        ->orderBy('sort_order', 'asc')
        ->get();

        return view('customize', [
            'categories' => $categories
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'design_data' => 'required|array|min:1',
            'design_data.*' => 'integer'
        ]);

        $design = CustomDesign::create([
            'user_id' => Auth::id(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'design_data' => $validated['design_data'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your design has been submitted! We will email you with a quote shortly.'
        ]);
    }


    /**
     * Quoted into Pending
     */
    public function acceptQuote(CustomDesign $design)
    {
        if ($design->user_id !== Auth::id()) {
            abort(403, 'You do not own this design.');
        }
        if ($design->status !== 'quoted') {
            return redirect()->route('dashboard')->with('error', 'This quote is not ready or has already been completed.');
        }

        $componentIds = $design->design_data;
        $counts = array_count_values(array_filter($componentIds));
        
        if (empty($counts)) {
            return redirect()->back()->with('error', 'This design is empty and cannot be processed.');
        }

        $componentsNeeded = Component::find(array_keys($counts));
        
        foreach ($componentsNeeded as $component) {
            $quantityNeeded = $counts[$component->id];
            if ($component->stock < $quantityNeeded) {
                return redirect()->back()->with('error', "Sorry, we are out of stock for: {$component->name}. Please contact us.");
            }
        }


        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_tracking_id' => 'BB-' . Str::upper(Str::random(8)),
                'total_amount' => $design->final_price,
                'payment_method' => null,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'custom_design_id' => $design->id,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => 21,
                'quantity' => 1,
                'price' => $design->final_price,
            ]);

            foreach ($componentsNeeded as $component) {
                $quantityToDecrement = $counts[$component->id];
                $component->decrement('stock', $quantityToDecrement);
            }
            
            $design->update(['status' => 'complete']);
            
            UserActivity::create([
                'user_id' => Auth::id(),
                'message' => 'Accepted quote and created Order #' . $order->order_tracking_id,
                'url' => route('order.show', $order->order_tracking_id)
            ]);

            DB::commit();

            session([
                'checkout_total' => $order->total_amount,
                'checkout_order_id' => $order->id
            ]);

            return redirect()->route('payment.show');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Quote Accept Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Could not convert quote to order.');
        }
    }
}