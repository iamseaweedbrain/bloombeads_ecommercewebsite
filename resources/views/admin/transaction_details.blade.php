@extends('layouts.admin')

@section('content')
<style>
    .bracelet-preview-container {
        position: relative;
        width: 400px;
        height: 400px;
        margin: 2rem auto;
    }
    .bracelet-slot {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 32px;
        height: 32px;
        margin: -16px;
        border-radius: 50%;
        background-color: #f0f0f0;
        border: 2px dashed #d1d5db;
        background-size: cover;
        background-position: center;
    }
    .bracelet-slot.filled {
        border: 2px solid var(--color-sakura);
    }
</style>

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

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 card-radius mb-6">
            {{ session('error') }}
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
            
            @if($order->custom_design_id)
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-xl font-fredoka font-bold mb-4">Custom Design Details</h2>
                <p class="font-poppins text-dark/70 mb-4">This order was created from a custom design quote.</p>
                <a href="{{ route('admin.approvals.show', $order->custom_design_id) }}" 
                   class="inline-block py-3 px-6 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft">
                    View Submitted Design
                </a>
            </div>
            @endif

            <div class="bg-white p-6 card-radius shadow-soft">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
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
                    </div>
                    <div>
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
        </div>
        
        <div class="md:col-span-1 space-y-8 h-fit md:sticky md:top-24">
            
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-xl font-fredoka font-bold mb-4">Update Status</h2>
                
                <form action="{{ route('admin.transactions.update', $order) }}" method="POST" data-payment-method="{{ $order->payment_method }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
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
            
            <div class="bg-white p-6 card-radius shadow-soft">
                <h2 class="text-xl font-fredoka font-bold mb-4">Payment Receipt</h2>
                
                @if($order->payment_receipt_path)
                    <a href="{{ asset('storage/' . $order->payment_receipt_path) }}" target="_blank" title="Click to view full image"
                       class="block w-full">
                        <img src="{{ asset('storage/' . $order->payment_receipt_path) }}" alt="Payment Receipt" 
                             class="w-full max-h-96 object-cover card-radius border border-neutral hover:border-sky transition-all">
                    </a>
                @elseif($order->payment_method == 'cod')
                    <p class="font-poppins text-dark/70">
                        This is a Cash on Delivery (COD) order.
                    </p>
                @else
                    <p class="font-poppins text-dark/70">
                        No payment receipt was uploaded by the customer.
                    </p>
                @endif
            </div>
        </div>
        
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentStatusEl = document.getElementById('payment_status');
        const orderStatusEl = document.getElementById('order_status');
        const form = paymentStatusEl.closest('form');
        const paymentMethod = form.dataset.paymentMethod;
        
        if (!paymentStatusEl || !orderStatusEl || !form) return;

        const processingStatuses = ['processing', 'shipped', 'delivered'];
        const orderOptions = orderStatusEl.querySelectorAll('option');

        function syncOrderOptions() {
            let currentPayment = paymentStatusEl.value;
            let currentOrder = orderStatusEl.value;

            orderOptions.forEach(option => {
                option.disabled = false;
                option.style.color = '#000';
            });

            if (currentPayment === 'failed') {
                orderOptions.forEach(option => {
                    if (option.value !== 'cancelled') {
                        option.disabled = true;
                        option.style.color = '#999';
                    }
                });
                orderStatusEl.value = 'cancelled';
                
            } else if (paymentMethod === 'gcash' || paymentMethod === 'maya') {
                if (currentPayment !== 'paid') {
                    orderOptions.forEach(option => {
                        if (processingStatuses.includes(option.value)) {
                            option.disabled = true;
                            option.style.color = '#999';
                        }
                    });
                    if (processingStatuses.includes(currentOrder)) {
                        orderStatusEl.value = 'pending';
                    }
                }
            }
        }
        paymentStatusEl.addEventListener('change', syncOrderOptions);
        orderStatusEl.addEventListener('change', syncOrderOptions);
        syncOrderOptions();
    });
</script>
@endpush
@endsection