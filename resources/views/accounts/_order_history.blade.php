<h2 class="text-xl font-semibold mb-3 border-b pb-2 text-pink-600">Order History</h2>

@php
    $orders = $orders ?? [
        (object) [
            'id' => '#ORD-1024',
            'date' => '2025-10-20',
            'status' => 'Delivered',
            'total' => '₱1,299.00',
        ],
        (object) [
            'id' => '#ORD-1023',
            'date' => '2025-10-18',
            'status' => 'Pending',
            'total' => '₱850.00',
        ],
        (object) [
            'id' => '#ORD-1022',
            'date' => '2025-10-15',
            'status' => 'Cancelled',
            'total' => '₱699.00',
        ],
    ];
@endphp

@forelse ($orders as $order)
    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg mb-2">
        <div>
            <strong>{{ $order->id }}</strong>
            <p class="text-gray-500 text-sm">Date: {{ $order->date }}</p>
        </div>
        <div class="text-right">
            <span class="text-pink-500 font-semibold">{{ $order->status }}</span><br>
            <span class="font-bold">{{ $order->total }}</span>
        </div>
    </div>
@empty
    <p class="text-gray-500 italic">No orders found.</p>
@endforelse
