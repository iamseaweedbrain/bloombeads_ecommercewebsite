@extends('layouts.admin')

@section('content')
<section id="dashboard-view">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 card-radius shadow-soft">
            <h4 class="font-poppins text-sm text-dark/70">Total Revenue</h4>
            <p class="text-3xl font-fredoka font-bold text-sakura mt-1">₱12,540.50</p>
            <span class="text-sm text-success font-poppins">+15% vs last month</span>
        </div>
        <div class="bg-white p-6 card-radius shadow-soft">
            <h4 class="font-poppins text-sm text-dark/70">New Orders</h4>
            <p class="text-3xl font-fredoka font-bold text-sky mt-1">45</p>
            <span class="text-sm text-success font-poppins">+5 today</span>
        </div>
        <div class="bg-white p-6 card-radius shadow-soft">
            <h4 class="font-poppins text-sm text-dark/70">Pending Approvals</h4>
            <p class="text-3xl font-fredoka font-bold text-cta mt-1">2</p>
            <span class="text-sm text-dark/70 font-poppins">Needs attention</span>
        </div>
        <div class="bg-white p-6 card-radius shadow-soft">
            <h4 class="font-poppins text-sm text-dark/70">New Users</h4>
            <p class="text-3xl font-fredoka font-bold text-success mt-1">120</p>
            <span class="text-sm text-success font-poppins">+22% vs last month</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 card-radius shadow-soft">
            <h3 class="text-xl font-fredoka font-bold mb-4">Sales Over Time</h3>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 card-radius shadow-soft">
            <h3 class="text-xl font-fredoka font-bold mb-4">Top Products</h3>
            <div class="chart-container" style="height: 350px;">
                <canvas id="productChart"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection