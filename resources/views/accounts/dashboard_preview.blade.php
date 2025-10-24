
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-center mb-8">Account Dashboard</h1>

        <div class="grid md:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="col-span-1">
                <div class="bg-white rounded-2xl shadow p-4">
                    <ul class="space-y-2">
                        <li><a href="#user" class="block py-2 px-3 rounded-md bg-pink-500 text-white font-semibold">User Information</a></li>
                        <li><a href="#activity" class="block py-2 px-3 rounded-md hover:bg-gray-100">Recent Activity</a></li>
                        <li><a href="#orders" class="block py-2 px-3 rounded-md hover:bg-gray-100">Order History</a></li>
                    </ul>
                    <button class="w-full mt-4 bg-amber-400 hover:bg-amber-500 text-white font-bold py-2 rounded-md">LOG OUT</button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-3 space-y-6">
                <div id="user" class="bg-white rounded-2xl shadow p-6">
                    @include('accounts._user_information', ['user' => $user ?? null])
                </div>

                <div id="activity" class="bg-white rounded-2xl shadow p-6">
                    @include('accounts._recent_activity', ['activities' => $activities ?? []])
                </div>

                <div id="orders" class="bg-white rounded-2xl shadow p-6">
                    @include('accounts._order_history', ['orders' => $orders ?? []])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
