<x-layout>
    <section id="dashboard-view" class="py-12 md:py-16">
        <!-- H2: Fredoka Bold -->
        <h2 class="text-3xl font-fredoka font-bold mb-8 md:mb-12">Account Dashboard</h2>

        <div class="md:grid md:grid-cols-4 gap-8">
            <!-- Left Sidebar: Tabs (Operational) -->
            <aside class="md:col-span-1">
                <div class="bg-white p-4 card-radius shadow-soft sticky top-20">
                    <!-- Tab: User Info (Name, Address, Contact) -->
                    <button id="tab-btn-user-info" onclick="setDashboardTab('user-info')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-sakura text-white">User Information</button>
                    <!-- Tab: Recent Activity -->
                    <button id="tab-btn-activity" onclick="setDashboardTab('activity')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-neutral text-dark hover:bg-gray-200">Recent Activity</button>
                    <!-- Tab: Order History -->
                    <button id="tab-btn-orders" onclick="setDashboardTab('orders')" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-neutral text-dark hover:bg-gray-200">Order History</button>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dashboard-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-cta text-white hover:bg-cta/80 mt-4">
                            LOG OUT
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Right Content Area (3/4 width) -->
            <div class="md:col-span-3 bg-white p-8 card-radius shadow-soft mt-8 md:mt-0">
                
                <!-- Dashboard User Info Content (Name, Address, Contact - Operational Data) -->
                <div id="dashboard-user-info-content">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">User Info (Shipping & Contact)</h3>
                    <div class="space-y-4 font-poppins">
                        <p><strong>Full Name:</strong> {{ Auth::user()->fullName }} </p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }} </p>
                        <p><strong>Contact Number:</strong> {{ Auth::user()->contact_number }} </p>
                        <p><strong>Shipping Address:</strong> {{ Auth::user()->address }} </p>
                        <p><strong>Primary Payment:</strong> {{ Auth::user()->fullName }} </p>
                        <button class="mt-4 py-2 px-6 font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80 transition-default">Update Contact Info</button>
                    </div>
                </div>

                <!-- Dashboard Recent Activity Content -->
                <div id="dashboard-activity-content" class="hidden">
                        <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Recent Activity</h3>
                    <div class="space-y-4 font-poppins">
                        <div class="p-3 bg-neutral card-radius border border-gray-200">
                            <p class="text-sm text-dark/70">1 hour ago</p>
                            <p class="font-semibold">Saved new Custom Bracelet Design: "Moonlit Dragon"</p>
                        </div>
                        <div class="p-3 bg-neutral card-radius border border-gray-200">
                            <p class="text-sm text-dark/70">Yesterday</p>
                            <p class="font-semibold">Placed Order #BB1025-001 (₱98.00)</p>
                        </div>
                        <div class="p-3 bg-neutral card-radius border border-gray-200">
                            <p class="text-sm text-dark/70">3 days ago</p>
                            <p class="font-semibold">Viewed product: Kawaii Jewelry Box</p>
                        </div>
                    </div>
                </div>
                
                <!-- Dashboard Order History Content -->
                <div id="dashboard-orders-content" class="hidden">
                        <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Order History</h3>
                    <div class="space-y-4 font-poppins">
                        <!-- Mock Order 1 -->
                        <div class="p-4 bg-neutral card-radius border border-gray-200">
                            <p class="font-bold flex justify-between">Order #BB1025-001 <span class="text-sakura">DELIVERED</span></p>
                            <p class="text-sm">Date: 10/25/2025 | Total: ₱98.00 (2 items)</p>
                            <button class="text-sm text-sky mt-2 hover:underline">View Details / Track</button>
                        </div>
                        <!-- Mock Order 2 -->
                        <div class="p-4 bg-neutral card-radius border border-gray-200">
                            <p class="font-bold flex justify-between">Order #BB0915-005 <span class="text-sky">SHIPPED</span></p>
                            <p class="text-sm">Date: 09/15/2025 | Total: ₱85.00 (1 item)</p>
                            <button class="text-sm text-sky mt-2 hover:underline">View Details / Track</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function setDashboardTab(tabId) {
            currentDashboardTab = tabId;
            document.getElementById('dashboard-user-info-content').classList.add('hidden');
            document.getElementById('dashboard-activity-content').classList.add('hidden');
            document.getElementById('dashboard-orders-content').classList.add('hidden');
            
            document.getElementById('dashboard-' + tabId + '-content').classList.remove('hidden');

            document.querySelectorAll('.dashboard-tab-btn').forEach(btn => {
                btn.classList.remove('bg-sakura', 'text-white');
                btn.classList.add('bg-neutral', 'text-dark');
            });
            document.getElementById('tab-btn-' + tabId).classList.remove('bg-neutral', 'text-dark');
            document.getElementById('tab-btn-' + tabId).classList.add('bg-sakura', 'text-white');
        }
    </script>
</x-layout>