@extends('layouts.admin') {{-- Make sure this matches your admin layout component --}}

@section('content')
<section id="admin-dashboard">
    <h2 class.="text-3xl font-fredoka font-bold mb-6">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 card-radius shadow-soft border border-neutral/50">
            <h4 class="font-poppins text-sm text-dark/70">Total Revenue</h4>
            <p class="text-3xl font-fredoka font-bold text-sakura mt-2">
                ₱{{ number_format($totalRevenue, 2) }}
            </p>
            <p class="font-poppins text-xs text-dark/70 mt-1">All non-cancelled sales</p>
        </div>
        
        <div class="bg-white p-6 card-radius shadow-soft border border-neutral/50">
            <h4 class="font-poppins text-sm text-dark/70">New Orders</h4>
            <p class="text-3xl font-fredoka font-bold text-sky mt-2">
                {{ $newOrders }}
            </p>
            <p class="font-poppins text-xs text-dark/70 mt-1">Orders with 'pending' status</p>
        </div>

        <div class_name="bg-white p-6 card-radius shadow-soft border border-neutral/50">
            <h4 class="font-poppins text-sm text-dark/70">Pending Approvals</h4>
            <p class="text-3xl font-fredoka font-bold text-cta mt-2">
                {{ $pendingApprovals }}
            </p>
            <p class="font-poppins text-xs text-dark/70 mt-1">Custom designs awaiting quote</p>
        </div>

        <div class_name="bg-white p-6 card-radius shadow-soft border border-neutral/50">
            <h4 class="font-poppins text-sm text-dark/70">Total Users</h4>
            <p class="text-3xl font-fredoka font-bold text-green-600 mt-2">
                {{ $totalUsers }}
            </p>
            <p class="font-poppins text-xs text-dark/70 mt-1">Total registered accounts</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 card-radius shadow-soft border border-neutral/50">
            <h3 class="text-xl font-fredoka font-bold mb-4">Sales Over Time (Last 7 Days)</h3>
            <div>
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-1 bg-white p-6 card-radius shadow-soft border border-neutral/50">
            <h3 class="text-xl font-fredoka font-bold mb-4">Top Products (Delivered)</h3>
            <div>
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data from AdminDashboardController
    const salesLabels = @json($salesLabels);
    const salesValues = @json($salesValues);
    const topProductsLabels = @json($topProductsLabels);
    const topProductsValues = @json($topProductsValues);

    document.addEventListener('DOMContentLoaded', () => {
        // --- Sales Over Time Chart ---
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Sales (₱)',
                        data: salesValues,
                        borderColor: '#FF6B81', // Sakura
                        backgroundColor: 'rgba(255, 107, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: (value) => `₱${value}`
                            }
                        }
                    }
                }
            });
        }

        // --- Top Products Chart ---
        const productsCtx = document.getElementById('topProductsChart');
        if (productsCtx) {
            new Chart(productsCtx, {
                type: 'doughnut',
                data: {
                    labels: topProductsLabels,
                    datasets: [{
                        label: 'Units Sold',
                        data: topProductsValues,
                        backgroundColor: [
                            '#FF6B81', // Sakura
                            '#48DBFB', // Sky
                            '#FFB347', // CTA
                            '#333333'  // Dark
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection