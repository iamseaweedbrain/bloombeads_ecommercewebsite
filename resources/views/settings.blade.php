<x-layout>
    <section id="settings-view" class="py-12 md:py-16">
        <!-- H2: Fredoka Bold -->
        <h2 class="text-3xl font-fredoka font-bold mb-8 md:mb-12">Account Settings</h2>

        <div class="md:grid md:grid-cols-4 gap-8">
            <!-- Left Sidebar: Tabs (Account Management) -->
            <aside class="md:col-span-1">
                <div class="bg-white p-4 card-radius shadow-soft sticky top-20">
                    <!-- Tab: Profile Info (Account Mgmt) -->
                    <button id="tab-btn-settings-profile-info" onclick="setSettingsTab('profile-info')" class="settings-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-sakura text-white">Profile Information</button>
                    <!-- Tab: Password Change -->
                    <button id="tab-btn-settings-password" onclick="setSettingsTab('password')" class="settings-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2 bg-neutral text-dark hover:bg-gray-200">Password Change</button>
                </div>
            </aside>

            <!-- Right Content Area (3/4 width) -->
            <div class="md:col-span-3 bg-white p-8 card-radius shadow-soft mt-8 md:mt-0">
                
                <!-- Settings Profile Info Content (Account Data) -->
                <div id="settings-profile-info-content">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Account Profile (Name, Email, etc.)</h3>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 font-poppins">
                        @csrf
                        <input type="text" name="fullName" placeholder="Full Name" value="{{ auth()->user()->fullName }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                        <input type="email" name="email" placeholder="Email" value="{{ auth()->user()->email }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                        <input type="number" name="contact_number" placeholder="Contact Number" value="{{ auth()->user()->contact_number }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                        <input type="text" name="address" placeholder="Shipping Address" value="{{ auth()->user()->address }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                        <button type="submit" class="mt-4 py-2 px-6 font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80 transition-default">Save Profile Changes</button>
                    </form>
                </div>

                <!-- Settings Password Change Content -->
                <div id="settings-password-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Change Password</h3>
                    <form action="{{ route('password.update') }}" method="POST" class="space-y-4 font-poppins max-w-sm">
                        @csrf
                        <input type="password" name="current_password" placeholder="Current Password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150">
                        <input type="password" name="new_password" placeholder="New Password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150">
                        <input type="password" name="new_password_confirmation" placeholder="Confirm New Password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150">
                        <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                            UPDATE PASSWORD
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        function setSettingsTab(tabId) {
            currentSettingsTab = tabId;
            document.getElementById('settings-profile-info-content').classList.add('hidden');
            document.getElementById('settings-password-content').classList.add('hidden');
            
            document.getElementById('settings-' + tabId + '-content').classList.remove('hidden');

            document.querySelectorAll('.settings-tab-btn').forEach(btn => {
                btn.classList.remove('bg-sakura', 'text-white');
                btn.classList.add('bg-neutral', 'text-dark');
            });
            document.getElementById('tab-btn-settings-' + tabId).classList.remove('bg-neutral', 'text-dark');
            document.getElementById('tab-btn-settings-' + tabId).classList.add('bg-sakura', 'text-white');
        }
    </script>
</x-layout>
