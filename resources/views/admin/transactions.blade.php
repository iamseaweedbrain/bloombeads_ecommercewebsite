@extends('layouts.admin')

@section('content')
<section id="transactions-view">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Transactions</h2>

    <div class="mb-4">
        <label for="status-filter" class="font-poppins font-semibold mr-2">Filter by Status:</label>
        <select id="status-filter" class="p-2 card-radius border border-gray-300 font-poppins">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
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
                    <tr>
                        <td>#BB1025-001</td>
                        <td>Jane Doe</td>
                        <td>10/25/2025</td>
                        <td>₱98.00</td>
                        <td><span class="py-1 px-2 text-xs font-poppins font-semibold rounded bg-success/20 text-success">Delivered</span></td>
                        <td><button class="py-1 px-3 text-xs font-poppins card-radius text-dark bg-neutral hover:bg-gray-200">View Details</button></td>
                    </tr>
                    <tr>
                        <td>#BB1025-002</td>
                        <td>John Smith</td>
                        <td>10/25/2025</td>
                        <td>₱64.00</td>
                        <td><span class="py-1 px-2 text-xs font-poppins font-semibold rounded bg-sky/20 text-sky">Shipped</span></td>
                        <td><button class="py-1 px-3 text-xs font-poppins card-radius text-dark bg-neutral hover:bg-gray-200">View Details</button></td>
                    </tr>
                    <tr>
                        <td>#BB1025-003</td>
                        <td>Ai Tanaka</td>
                        <td>10/24/2025</td>
                        <td>₱39.00</td>
                        <td><span class="py-1 px-2 text-xs font-poppins font-semibold rounded bg-cta/20 text-cta">Pending</span></td>
                        <td><button class="py-1 px-3 text-xs font-poppins card-radius text-dark bg-neutral hover:bg-gray-200">View Details</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection