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
                @if ($errors->has('current_password') || $errors->has('new_password'))
                    @php setSettingsTab('password'); @endphp
                @endif
                <div id="settings-profile-info-content">
                    <h3 class="text-2xl font-fredoka font-bold text-dark mb-4 border-b pb-2 border-sakura">Account Profile (Name, Email, etc.)</h3>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 font-poppins">
                        @csrf
                        
                        <div>
                            <input type="text" name="firstName" placeholder="First Name" value="{{ old('firstName', $user->first_name) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('firstName') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="text" name="lastName" placeholder="Last Name" value="{{ old('lastName', $user->last_name) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('lastName') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <input type="email" name="email" placeholder="Email (must be @gmail.com)" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="tel" name="contact_number" placeholder="Contact Number (e.g., 09xxxxxxxxx)" value="{{ old('contact_number', $user->contact_number) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky transition-colors duration-150">
                            @error('contact_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <input type="text" name="address" placeholder="Shipping Address" value="{{ old('address', $user->address) }}" required
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
                        
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" placeholder="Current Password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150 pr-10">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('current_password')">
                                <i class="far fa-eye" id="toggle-current_password"></i>
                            </span>
                            @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password_input" placeholder="New Password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150 pr-10"
                                   oninput="validateNewPasswordInput()">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('new_password_input')">
                                <i class="far fa-eye" id="toggle-new_password_input"></i>
                            </span>
                            @error('new_password') 
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                            <div id="new-password-requirements" class="text-sm mt-1 text-gray-500"></div>
                        </div>

                        <div class="relative">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation_input" placeholder="Confirm New Password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500 transition-colors duration-150 pr-10"
                                   oninput="validateNewPasswordInput()">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('new_password_confirmation_input')">
                                <i class="far fa-eye" id="toggle-new_password_confirmation_input"></i>
                            </span>
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

        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(`toggle-${fieldId}`);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }


        function validateNewPasswordInput() {
            const passwordInput = document.getElementById('new_password_input');
            const confirmInput = document.getElementById('new_password_confirmation_input');
            const requirementsDiv = document.getElementById('new-password-requirements');
            const value = passwordInput.value;
            let errors = [];

            // Define required rules
            if (value.length < 8) errors.push('at least 8 characters');
            if (!/[A-Z]/.test(value)) errors.push('1 uppercase letter');
            if (!/\d/.test(value)) errors.push('1 number');
            if (!/[!@#$%^&*()]/.test(value)) errors.push('1 special character');

            let output = '';
            if (errors.length > 0) {
                output = 'Must contain: ' + errors.join(', ') + '.';
                requirementsDiv.className = 'text-sm mt-1 text-red-500';
            } else {
                output = 'Password meets all security requirements.';
                requirementsDiv.className = 'text-sm mt-1 text-green-600';
            }
            
            if (confirmInput.value && value !== confirmInput.value) {
                output += ' Passwords do not match.';
                requirementsDiv.className = 'text-sm mt-1 text-red-500';
            }

            requirementsDiv.textContent = output;
        }


        document.addEventListener('DOMContentLoaded', () => {
            const hasPasswordErrors = @json($errors->has('current_password') || $errors->has('new_password'));
            
            if (hasPasswordErrors) {
                setSettingsTab('password');
                validateNewPasswordInput();
            } else {
                const hasProfileErrors = @json($errors->any());
                if (hasProfileErrors) {
                    setSettingsTab('profile-info');
                } else {
                    setSettingsTab('profile-info');
                }
            }
        });
    </script>
</x-layout>