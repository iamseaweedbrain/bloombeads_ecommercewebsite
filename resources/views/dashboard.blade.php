<x-layout>
    <section id="dashboard-view" class="py-12 md:py-16">
        <h2 class="text-3xl font-fredoka font-bold mb-8 md:mb-12">Account Dashboard</h2>

        <div class="md:grid md:grid-cols-4 gap-8">
            <aside class="md:col-span-1">
                <div class="bg-white p-4 card-radius shadow-soft sticky top-20">
                    <button id="tab-btn-user-info" onclick="setDashboardTab('user-info')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">User Information</button>
                    <button id="tab-btn-activity" onclick="setDashboardTab('activity')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">Recent Activity</button>
                    <button id="tab-btn-orders" onclick="setDashboardTab('orders')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">Order History</button>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-cta text-white mt-4">
                            LOG OUT
                        </button>
                    </form>
                </div>
            </aside>

            <div class="md:col-span-3 bg-white p-6 sm:p-8 card-radius shadow-soft mt-8 md:mt-0">
                
                <div id="dashboard-user-info-content">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">User Info (Shipping & Contact)</h3>
                    <div class="space-y-4 font-poppins">
                        <p><strong>Full Name:</strong> {{ $user->fullName }} </p>
                        <p><strong>Email:</strong> {{ $user->email }} </p>
                        <p><strong>Contact Number:</strong> {{ $user->contact_number ?? 'Not set' }} </p>
                        <p><strong>Shipping Address:</strong> {{ $user->address ?? 'Not set' }} </p>
                        <a href="{{ route('settings') }}" class="mt-4 inline-block py-2 px-6 font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80 transition-default">
                            Update Contact Info
                        </a>
                    </div>
                </div>

                <div id="dashboard-activity-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Recent Activity</h3>
                    
                    <div class="space-y-4 font-poppins">
                        @forelse ($activities as $activity)
                            <div class="p-3 bg-neutral card-radius border border-gray-200">
                                <p class="text-sm text-dark/70">{{ $activity->created_at->diffForHumans() }}</p>
                                
                                @if($activity->url)
                                    <a href="{{ $activity->url }}" class="font-semibold text-sakura hover:text-sky hover:underline transition-default">
                                        {{ $activity->message }}
                                    </a>
                                @else
                                    <p class="font-semibold text-dark">{{ $activity->message }}</p>
                                @endif

                            </div>
                        @empty
                            <div class="p-3 bg-neutral card-radius border border-gray-200">
                                <p class="font-semibold text-dark">No recent activity to show.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div id="dashboard-orders-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Order History</h3>
                    
                    <nav class="flex border-b border-neutral overflow-x-auto mb-6">
                        @php
                            $filters = [
                                'all' => 'All',
                                'to-pay' => 'To Pay',
                                'to-ship' => 'To Ship',
                                'to-receive' => 'To Receive',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled'
                            ];
                        @endphp

                        @foreach ($filters as $key => $value)
                            <a href="{{ route('dashboard', ['status' => $key]) }}"
                               class="dashboard-filter-tab py-3 px-4 font-poppins font-semibold whitespace-nowrap
                                  {{ $activeStatusFilter == $key ? 'text-sakura border-b-2 border-sakura' : 'text-dark/60 hover:text-dark' }}">
                                {{ $value }}
                            </a>
                        @endforeach
                    </nav>

                    <div class="space-y-6 font-poppins">
                        
                        @forelse ($orders as $order)
                            <a href="{{ route('order.show', $order->order_tracking_id) }}" 
                               class="block border border-neutral card-radius overflow-hidden shadow-soft hover:shadow-lg hover:border-sakura/40 transition-all duration-300">
                                
                                <div class="bg-neutral/70 p-4 flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold text-dark">
                                            Order #{{ $order->order_tracking_id }}
                                        </span>
                                        <p class="text-sm text-dark/70">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    @php
                                        $statusClass = 'text-dark/70';
                                        if ($order->order_status == 'delivered') $statusClass = 'text-green-600';
                                        elseif ($order->order_status == 'shipped') $statusClass = 'text-sky';
                                        elseif ($order->order_status == 'processing') $statusClass = 'text-blue-500';
                                        elseif ($order->order_status == 'pending') $statusClass = 'text-cta';
                                        elseif ($order->order_status == 'cancelled') $statusClass = 'text-red-500';
                                    @endphp
                                    <span class="font-fredoka font-bold text-sm uppercase {{ $statusClass }}">
                                        {{ $order->order_status }}
                                    </span>
                                </div>
                                
                                <div class="p-4 space-y-4">
                                    @foreach ($order->items as $item)
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $item->product->image_path ? asset('storage/' . $item->product->image_path) : 'https://placehold.co/80x80/FF6B81/FFFFFF?text=B' }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-16 h-16 card-radius object-cover bg-gray-100 flex-shrink-0">
                                            <div class="flex-grow">
                                                <p class="font-semibold text-dark">{{ $item->product->name }}</p>
                                                <p class="text-sm text-dark/70">x {{ $item->quantity }}</p>
                                            </div>
                                            <p class="font-semibold text-dark">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="bg-neutral/70 p-4 text-right">
                                    <p class="font-poppins text-dark">
                                        Order Total: 
                                        <span class="font-fredoka font-bold text-xl text-sakura ml-2">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </p>
                                </div>
                            </a> 
                        @empty
                            <div class="text-center py-10 text-dark/70">
                                <p class="text-lg font-fredoka mb-3">No orders found in this category.</p>
                                <p>You have not placed any orders yet, or your orders are in another status.</p>
                            </div>
                        @endforelse

                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function setDashboardTab(tabId) {
            document.getElementById('dashboard-user-info-content').classList.add('hidden');
            document.getElementById('dashboard-activity-content').classList.add('hidden');
            document.getElementById('dashboard-orders-content').classList.add('hidden');
            
            document.getElementById('dashboard-' + tabId + '-content').classList.remove('hidden');

            document.querySelectorAll('.dashboard-tab-btn').forEach(btn => {
                if (!btn.closest('form')) {
                    btn.classList.remove('bg-sakura', 'text-white');
                    btn.classList.add('bg-neutral', 'text-dark');
                }
            });
            
            const activeBtn = document.getElementById('tab-btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.remove('bg-neutral', 'text-dark');
                activeBtn.classList.add('bg-sakura', 'text-white');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currentUrl = new URL(window.location.href);
            if (currentUrl.searchParams.has('status')) {
                setDashboardTab('orders');
            } else {
                setDashboardTab('user-info');
            }
        });
    </script>
</x-layout>