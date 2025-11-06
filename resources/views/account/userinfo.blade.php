<x-format>
    <div class="flex min-h-screen bg-gradient-to-br from-pink-100 via-white to-pink-50">

        <!-- Sidebar -->
        <aside class="w-80 bg-transparent text-gray-600 p-10">
            <h2 class="text-3xl font-bold text-center text-rose-600 mb-8">account DashBoard</h2>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-pink-100">
                <nav class="space-y-3">
                    <a href="{{ route('dashboard.user') }}"
                       class="block px-3 py-2 rounded-lg bg-rose-100 text-rose-700 font-semibold shadow-sm hover:bg-rose-200 transition">
                        👤 User Information
                    </a>

                    <a href="{{ route('dashboard.activity') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-rose-100 hover:text-rose-700 font-medium transition">
                        🔔 Recent Activity
                    </a>

                    <a href="{{ route('dashboard.orders') }}"
                       class="block px-3 py-2 rounded-lg hover:bg-rose-100 hover:text-rose-700 font-medium transition">
                        🛍️ Order History
                    </a>

                    <a href="{{ route('logout') }}"
                       class="block mt-6 px-3 py-2 rounded-lg text-white bg-gradient-to-r from-yellow-400 to-orange-500 font-medium shadow-md hover:from-yellow-500 hover:to-orange-600 hover:shadow-lg transition duration-200 text-center">
                        Log Out
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10">
            
            <br><br><br>
            <!-- User Info Box -->
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-pink-100 max-w-3xl">
                <div class="border-b border-pink-200 pb-3 mb-8">
                    <h2 class="text-lg font-semibold text-rose-600">User Info (Shipping & Contact)</h2>
                </div>

                <div class="space-y-3 text-gray-700">
                    <p><span class="font-semibold text-gray-800">Full Name:</span> John Doe</p>
                    <p><span class="font-semibold text-gray-800">Email:</span> john.doe@bloombeads.com</p>
                    <p><span class="font-semibold text-gray-800">Contact Number:</span> (555) 123-4567</p>
                    <p><span class="font-semibold text-gray-800">Shipping Address:</span> 123 Sakura Lane, Anime City, CA 90210</p>
                    <p><span class="font-semibold text-gray-800">Primary Payment:</span> Visa ending in 4242</p>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 bg-rose-500 text-white rounded-lg font-medium shadow-md hover:bg-rose-600 transition">
                        Update Contact Info
                    </button>
                </div>
            </div>
        </main>

    </div>
</x-format>