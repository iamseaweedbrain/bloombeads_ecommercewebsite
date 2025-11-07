<x-layout>
    <section id="settings-view" class="py-12 md:py-16">
        <h2 class="text-3xl font-fredoka font-bold mb-8 md:mb-12">Account Settings</h2>

        <div class="md:grid md:grid-cols-4 gap-8">
            <aside class="md:col-span-1">
                <div class="bg-white p-4 card-radius shadow-soft sticky top-20">
                    <button id="tab-btn-settings-profile-info" onclick="setSettingsTab('profile-info')" class="settings-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">Profile Information</button>
                    <button id="tab-btn-settings-password" onclick="setSettingsTab('password')" class="settings-tab-btn w-full text-left py-3 px-4 font-fredoka font-bold card-radius transition-default mb-2">Password Change</button>
                </div>
            </aside>

            <div class="md:col-span-3 bg-white p-8 card-radius shadow-soft mt-8 md:mt-0">
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 card-radius font-poppins">
                        {{ session('success') }}
                    </div>
                @endif
                <div id="settings-profile-info-content">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Account Profile (Name, Email, etc.)</h3>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 font-poppins">
                        @csrf
                        
                        <div>
                            <input type="text" name="fullName" placeholder="Full Name" value="{{ old('fullName', $user->fullName) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('fullName') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="tel" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number', $user->contact_number) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('contact_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="text" name="address" placeholder="Shipping Address" value="{{ old('address', $user->address) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="mt-4 py-2 px-6 font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80 transition-default">Save Profile Changes</button>
                    </form>
                </div>

                <div id="settings-password-content" class="hidden">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Change Password</h3>
                    <form action="{{ route('password.update') }}" method="POST" class="space-y-4 font-poppins max-w-sm">
                        @csrf
                        
                        <div>
                            <input type="password" name="current_password" placeholder="Current Password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150">
                            @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="password" name="new_password" placeholder="New Password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150">
                            @error('new_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <input type="password" name="new_password_confirmation" placeholder="Confirm New Password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150">
                        </div>

                        <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                            UPDATE PASSWORD
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        let currentSettingsTab = 'profile-info';

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

        document.addEventListener('DOMContentLoaded', () => {
            const hasPasswordErrors = @json($errors->has('current_password') || $errors->has('new_password'));
            
            if (hasPasswordErrors) {
                setSettingsTab('password');
            } else {
                setSettingsTab('profile-info');
            }
        });
    </script>
</x-layout>