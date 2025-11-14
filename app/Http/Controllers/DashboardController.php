<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CustomDesign;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;
use App\Models\Component; // <-- 1. THIS IS ADDED

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->query('status', 'all');

        // --- Get Orders ---
        $orderQuery = $user->orders()
                            ->with('items.product')
                            ->orderBy('created_at', 'desc');

        switch ($statusFilter) {
            case 'to-pay':
                $orderQuery->whereIn('payment_status', ['pending', 'unpaid'])
                            ->where('order_status', '!=', 'cancelled');
                break;
            case 'to-ship':
                $orderQuery->where('payment_status', 'paid')
                            ->whereIn('order_status', ['pending', 'processing']);
                break;
            case 'to-receive':
                $orderQuery->where('order_status', 'shipped');
                break;
            case 'completed':
                $orderQuery->where('order_status', 'delivered');
                break;
            case 'cancelled':
                $orderQuery->where('order_status', 'cancelled');
                break;
        }
        
        $orders = $orderQuery->paginate(5)->withQueryString();


        // --- Get Recent Activities ---
        $activities = $user->activities()
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                            
        $customDesigns = $user->customDesigns()
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // --- 2. THIS LINE IS ADDED ---
        $allComponents = Component::all()->keyBy('id');


        return view('dashboard', [
            'user' => $user,
            'orders' => $orders,
            'activities' => $activities, 
            'customDesigns' => $customDesigns,
            'activeStatusFilter' => $statusFilter,
            'allComponents' => $allComponents // <-- 3. THIS VARIABLE IS ADDED
        ]);
    }

    /**
     * Show the details for a single order.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $order->load('user', 'items.product');

        return view('order_details', [
            'order' => $order
        ]);
    }
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to cancel this order.');
        }

        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'This order can no longer be cancelled.');
        }

        DB::beginTransaction();
        try {
            
            $order->load('items.product');
            foreach($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            
            if ($order->custom_design_id) {
                $design = $order->customDesign;
                if ($design) {
                    $componentIds = $design->design_data;
                    $counts = array_count_values(array_filter($componentIds));
                    if (!empty($counts)) {
                        $componentsToRestock = Component::find(array_keys($counts));
                        foreach ($componentsToRestock as $component) {
                            $quantityToRestock = $counts[$component->id];
                            $component->increment('stock', $quantityToRestock);
                        }
                    }
                }
            }

            $order->update([
                'order_status' => 'cancelled',
                'payment_status' => 'failed'
            ]);
            
            UserActivity::create([
                'user_id' => Auth::id(),
                'message' => 'Cancelled Order #' . $order->order_tracking_id,
                'url' => route('order.show', $order->order_tracking_id)
            ]);

            DB::commit();

            return redirect()->route('dashboard', ['status' => 'cancelled'])->with('success', 'Your order has been successfully cancelled.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('User Order Cancel Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Could not cancel the order.');
        }
    }
}