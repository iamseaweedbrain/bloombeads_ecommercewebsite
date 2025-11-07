@extends('layouts.admin')

@section('content')
<section id="transaction-details-view" class="font-poppins">

    <a href="{{ route('admin.transactions') }}" class="flex items-center text-sky hover:text-opacity-80 font-fredoka font-semibold mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Back to Transactions
    </a>

    @if(session('success'))
        <div class="bg-success/20 text-success p-4 card-radius mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-2 space-y-8">
            
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-xl font-fredoka font-bold mb-4">
                    Order Items ({{ $order->items->count() }})
                </h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 border-b border-neutral/50 pb-4 last:border-b-0 last:pb-0">
                            @if($item->product)
                                <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://placehold.co/80x80/FF6B81/FFFFFF?text=B' }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-16 h-16 card-radius object-cover bg-gray-100">
                                <div class="flex-grow">
                                    <h4 class="font-poppins font-semibold text-dark">{{ $item->product->name }}</h4>
                                    <p class="text-sm font-poppins text-dark/70">
                                        {{ $item->quantity }} x ₱{{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                <div class="font-poppins font-bold text-dark">
                                    ₱{{ number_format($item->quantity * $item->price, 2) }}
                                </div>
                            @else
                                <div class="text-red-500">
                                    [Product not found - ID: {{ $item->product_id }}]
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-xl font-fredoka font-bold mb-4">Update Status</h2>
                <form action="{{ route('admin.transactions.update', $order) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="payment_status" class="block font-semibold mb-2">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="w-full p-2 card-radius border border-gray-300">
                                <option value="pending" @selected($order->payment_status == 'pending')>Pending (Awaiting GCash/Maya)</option>
                                <option value="paid" @selected($order->payment_status == 'paid')>Paid (Payment Confirmed)</option>
                                <option value="unpaid" @selected($order->payment_status == 'unpaid')>Unpaid (COD)</option>
                                <option value="failed" @selected($order->payment_status == 'failed')>Failed</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="order_status" class="block font-semibold mb-2">Order Status</label>
                            <select name="order_status" id="order_status" class="w-full p-2 card-radius border border-gray-300">
                                <option value="pending" @selected($order->order_status == 'pending')>Pending</option>
                                <option value="processing" @selected($order->order_status == 'processing')>Processing (In Progress)</option>
                                <option value="shipped" @selected($order->order_status == 'shipped')>Shipped</option>
                                <option value="delivered" @selected($order->order_status == 'delivered')>Delivered</option>
                                <option value="cancelled" @selected($order->order_status == 'cancelled')>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-right mt-6">
                        <button type="submit" class="bg-cta text-white font-fredoka font-bold py-2 px-6 card-radius shadow-soft hover:bg-opacity-90">
                            Update Order
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
        
        <div class="md:col-span-1 h-fit md:sticky md:top-24">
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-xl font-fredoka font-bold mb-4">Order Details</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-dark/70">Order ID:</span>
                        <span class="font-semibold text-dark">#{{ $order->order_tracking_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark/70">Order Date:</span>
                        <span class="font-semibold text-dark">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark/70">Payment Method:</span>
                        <span class="font-semibold text-dark">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg pt-2 border-t border-neutral">
                        <span class="text-dark">Total:</span>
                        <span class="text-sakura">₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <hr class="my-6 border-neutral/60">

                <h2 class="text-xl font-fredoka font-bold mb-4">Customer Details</h2>
                <div class="space-y-2 text-dark/90">
                    <p>
                        <strong>Name:</strong>
                        <span>{{ $order->user ? $order->user->fullName : 'Guest' }}</span>
                    </p>
                    <p>
                        <strong>Email:</strong>
                        <span>{{ $order->user ? $order->user->email : 'N/A' }}</span>
                    </p>
                    
                    <p>
                        <strong>Phone:</strong>
                        <span>{{ $order->user ? ($order->user->contact_number ?? 'Not set') : 'N/A' }}</span>
                    </p>
                    <p class="pt-2 border-t border-neutral">
                        <strong>Shipping Address:</strong>
                        <span class="block mt-1 text-dark/70">{{ $order->user ? ($order->user->address ?? 'Not set') : 'N/A' }}</span>
                    </p>
                </div>
            </div>
        </div>
        
    </div>
</section>
@endsection