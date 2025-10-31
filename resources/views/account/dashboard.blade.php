<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-center mb-10 text-gray-800">
            🌸 Welcome Back, User!
        </h1>

        <div class="grid md:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="w-80 bg-transparent text-gray-600 p-10">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-pink-50">
                    <nav class="space-y-3">
                        <a href="{{ route('account.dashboard') }}"
                           class="block px-3 py-2 rounded-lg font-medium transition 
                           {{ request()->routeIs('account.dashboard') 
                              ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                              : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700' }}">
                            🏠 Dashboard
                        </a>

                        <a href="{{ route('account.info') }}"
                           class="block px-3 py-2 rounded-lg font-medium transition 
                           {{ request()->routeIs('account.info') 
                              ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                              : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700' }}">
                            👤 User Information
                        </a>

                        <a href="{{ route('account.activity') }}"
                           class="block px-3 py-2 rounded-lg font-medium transition 
                           {{ request()->routeIs('account.activity') 
                              ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                              : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700' }}">
                            🔔 Recent Activity
                        </a>

                        <a href="{{ route('account.orders') }}"
                           class="block px-3 py-2 rounded-lg font-medium transition 
                           {{ request()->routeIs('account.orders') 
                              ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                              : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700' }}">
                            🛍️ Order History
                        </a>
                    </nav>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-6">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 rounded-md font-medium text-white 
                                   bg-orange-500 hover:bg-orange-600 
                                   shadow-md hover:shadow-lg transition-all duration-200">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m0-8V7a2 2 0 114 0v1" />
                                </svg>
                                Log Out
                            </span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Dashboard Content -->
            <main class="col-span-3 space-y-6">
                <section id="dashboard" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">🌟 Quick Overview</h3>

                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-pink-400 to-rose-500 text-white p-5 rounded-xl shadow-md hover:shadow-lg transition">
                            <h4 class="text-lg font-semibold">Total Orders</h4>
                            <p class="text-3xl font-bold mt-2">24</p>
                            <p class="text-sm opacity-90 mt-1">+3 this month</p>
                        </div>

                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-5 rounded-xl shadow-md hover:shadow-lg transition">
                            <h4 class="text-lg font-semibold">Points Earned</h4>
                            <p class="text-3xl font-bold mt-2">1,250</p>
                            <p class="text-sm opacity-90 mt-1">Earned this year</p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-400 to-indigo-500 text-white p-5 rounded-xl shadow-md hover:shadow-lg transition">
                            <h4 class="text-lg font-semibold">Last Login</h4>
                            <p class="text-xl font-bold mt-2">2 hours ago</p>
                            <p class="text-sm opacity-90 mt-1">From Chrome, Windows</p>
                        </div>
                    </div>

                    <div class="bg-pink-50 border border-pink-100 rounded-xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800">💬 Welcome Back, Jan!</h4>
                            <p class="text-gray-600">Here’s your quick summary for today. Check your activity or start a new order anytime!</p>
                        </div>
                        <img src="https://cdn-icons-png.flaticon.com/512/7010/7010250.png"
                             alt="Welcome" class="w-24 h-24 drop-shadow-md">
                    </div>
                </section>

                <section id="user" class="bg-white rounded-2xl shadow p-6 text-center text-gray-600 italic">
                    Select a section from the sidebar to view more details.
                </section>
            </main>
        </div>
    </div>
</x-layout>
