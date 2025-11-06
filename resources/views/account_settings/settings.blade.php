<x-layout>
    <div class="max-w-5xl mx-auto mt-10 flex gap-8">
        {{-- Sidebar --}}
        <aside class="w-1/4 bg-white shadow rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Settings</h2>
            <ul class="space-y-2">
                <li>
                    <button id="profileTab" class="tab-btn active-tab w-full text-left px-4 py-2 rounded-lg font-medium hover:bg-pink-100 transition">
                        👤 Profile
                    </button>
                </li>
                <li>
                    <button id="passwordTab" class="tab-btn w-full text-left px-4 py-2 rounded-lg font-medium hover:bg-pink-100 transition">
                        🔒 Password
                    </button>
                </li>
            </ul>
        </aside>

        {{-- Content Area --}}
        <section class="w-3/4 bg-white shadow rounded-xl p-8">
            {{-- Profile Form --}}
            <div id="profileContent" class="tab-content">
                <h1 class="text-2xl font-bold text-sakura mb-6">Profile Information</h1>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="fullName" class="block font-medium text-gray-700">Full Name</label>
                        <input type="text" name="fullName" id="fullName"
                               value="{{ old('fullName', session('user')->fullName ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <div>
                        <label for="email" class="block font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', session('user')->email ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <div>
                        <label for="phone" class="block font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" id="phone"
                               value="{{ old('phone', session('user')->phone ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <div>
                        <label for="birthday" class="block font-medium text-gray-700">Birthday</label>
                        <input type="date" name="birthday" id="birthday"
                               value="{{ old('birthday', session('user')->birthday ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <button type="submit" class="bg-sakura text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition-all">
                        Save Changes
                    </button>
                </form>
            </div>

            {{-- Password Form --}}
            <div id="passwordContent" class="tab-content hidden">
                <h1 class="text-2xl font-bold text-sakura mb-6">Change Password</h1>

                <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="current_password" class="block font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" id="current_password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <div>
                        <label for="new_password" class="block font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" id="new_password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-sakura outline-none">
                    </div>

                    <button type="submit" class="bg-sakura text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition-all">
                        Update Password
                    </button>
                </form>
            </div>
        </section>
    </div>

    {{-- Simple tab switcher --}}
    <script>
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active-tab', 'bg-pink-100'));
                tab.classList.add('active-tab', 'bg-pink-100');
                contents.forEach(c => c.classList.add('hidden'));
                const id = tab.id === 'profileTab' ? 'profileContent' : 'passwordContent';
                document.getElementById(id).classList.remove('hidden');
            });
        });
    </script>
</x-layout>
