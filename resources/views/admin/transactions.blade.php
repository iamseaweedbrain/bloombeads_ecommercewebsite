@extends('layouts.admin')

@section('content')
<section id="transactions-view">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Transactions</h2>

    <div class="mb-4">
        <form action="{{ route('admin.transactions') }}" method="GET">
            <label for="status-filter" class="font-poppins font-semibold mr-2">Filter by Status:</label>
            <select name="status" id="status-filter" class="p-2 card-radius border border-gray-300 font-poppins" onchange="this.form.submit()">
                <option value="all" @selected(!request('status') || request('status') == 'all')>All</option>
                <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                <option value="processing" @selected(request('status') == 'processing')>Processing</option>
                <option value="shipped" @selected(request('status') == 'shipped')>Shipped</option>
                <option value="delivered" @selected(request('status') == 'delivered')>Delivered</option>
                <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
            </select>
        </form>
    </div>

    <div class="bg-white card-radius shadow-soft overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->order_tracking_id }}</td>
                            <td>{{ $order->user ? $order->user->fullName : 'Guest' }}</td>
                            <td>{{ $order->created_at->format('m/d/Y') }}</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    if ($order->order_status == 'delivered') $statusClass = 'bg-success/20 text-success';
                                    elseif ($order->order_status == 'shipped') $statusClass = 'bg-sky/20 text-sky';
                                    elseif ($order->order_status == 'pending') $statusClass = 'bg-cta/20 text-cta';
                                    elseif ($order->order_status == 'processing') $statusClass = 'bg-blue-500/20 text-blue-500';
                                    elseif ($order->order_status == 'cancelled') $statusClass = 'bg-red-500/20 text-red-500';
                                    else $statusClass = 'bg-gray-400/20 text-gray-400';
                                @endphp
                                <span class="py-1 px-2 text-xs font-poppins font-semibold rounded {{ $statusClass }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $order) }}" class="py-1 px-3 text-xs font-poppins card-radius text-dark bg-neutral hover:bg-gray-200">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-dark/70 font-poppins">
                                You have no orders matching this filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</section>
@endsection