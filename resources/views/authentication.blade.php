<x-layout>
    <section id="auth-view" class="py-12 md:py-24">
        <div class="max-w-md mx-auto bg-white card-radius shadow-soft p-8 text-center">
            <h2 id="auth-title" class="text-3xl font-fredoka font-bold text-dark mb-6 border-b pb-3 border-neutral">
                Welcome Back! Sign In
            </h2>

            <div id="auth-message" class="text-sm font-poppins text-sakura mb-4">
                Please sign in or sign up to continue.
            </div>

            <div id="auth-status-message" class="h-6 font-poppins text-sm mb-4 text-center @if(session('success')) text-green-600 @elseif(session('error')) text-sakura @endif">
                @if(session('success'))
                    {{ session('success') }}
                @endif
                @if(session('error'))
                    {{ session('error') }}
                @endif
                @if(session('login_error')) 
                    {{ session('login_error') }}
                @endif
            </div>

            <div id="signin-form-container" class="space-y-4">
                <form id="signin-form" method="POST" action="{{ route('auth.login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                        @error('email')
                            <div class="text-sakura text-sm text-left mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="relative">
                        <input type="password" name="password" id="login-password" placeholder="Password" required class="w-full border border-neutral rounded-lg p-2 pr-10 focus:outline-sky">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('login-password')">
                            <i class="far fa-eye" id="toggle-login-password"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-sakura text-sm text-left -mt-3 mb-3">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                        LOG IN
                    </button>
                </form>

                <button type="button" onclick="setActiveView('forgot-password', event)" class="mt-4 text-sm font-poppins text-sky hover:text-dark transition-default">
                    Forgot Password?
                </button>

                <div class="my-6 border-t border-neutral pt-4">
                    <button type="button" onclick="setActiveView('signup')" class="text-sm font-poppins text-sky hover:text-dark transition-default">
                        Don't have an account? <strong class="underline">Sign Up Here</strong>
                    </button>
                </div>
            </div>

            <div id="signup-form-container" class="space-y-4 hidden">
                <form id="signup-form" method="POST" action="{{ route('auth.signup') }}" class="space-y-4" novalidate>
                    @csrf
                    
                    <div>
                        <input type="text" name="firstName" id="firstName" placeholder="First Name" value="{{ old('firstName') }}" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                        <div id="firstName-error" class="text-sakura text-sm text-left mt-1">
                            @error('firstName') {{ $message }} @enderror
                        </div>
                    </div>

                    <div>
                        <input type="text" name="lastName" id="lastName" placeholder="Last Name" value="{{ old('lastName') }}" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                        <div id="lastName-error" class="text-sakura text-sm text-left mt-1">
                            @error('lastName') {{ $message }} @enderror
                        </div>
                    </div>

                    <div>
                        <input type="email" name="email" id="email" placeholder="Email Address (must be @gmail.com)" value="{{ old('email') }}" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                        <div id="email-error" class="text-sakura text-sm text-left mt-1">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>

                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Create Password" required class="w-full border border-neutral rounded-lg p-2 pr-10 focus:outline-sky">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('password')">
                            <i class="far fa-eye" id="toggle-password"></i>
                        </span>
                    </div>
                    <div id="password-error" class="text-sakura text-sm text-left -mt-3 mb-3">
                        @error('password') {{ $message }} @enderror
                    </div>

                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required class="w-full border border-neutral rounded-lg p-2 pr-10 focus:outline-sky">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('password_confirmation')">
                            <i class="far fa-eye" id="toggle-password_confirmation"></i>
                        </span>
                    </div>
                    <div id="password_confirmation-error" class="text-sakura text-sm text-left -mt-3 mb-3">
                         @error('password_confirmation') {{ $message }} @enderror
                    </div>


                    <div>
                        <input type="text" name="contact_number" id="contact_number" placeholder="Phone Number (e.g., 09171234567)" value="{{ old('contact_number') }}" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                        <div id="contact_number-error" class="text-sakura text-sm text-left mt-1">
                            @error('contact_number') {{ $message }} @enderror
                        </div>
                    </div>

                    <div>
                        <input type="text" name="address" id="address" placeholder="Home Address" value="{{ old('address') }}" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                        <div id="address-error" class="text-sakura text-sm text-left mt-1">
                            @error('address') {{ $message }} @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                        SIGN UP
                    </button>
                </form>

                <div class="my-6 border-t border-neutral pt-4">
                    <button type="button" onclick="setActiveView('signin')" class="text-sm font-poppins text-sky hover:text-dark transition-default">
                        Already have an account? <strong class="underline">Sign In</strong>
                    </button>
                </div>
            </div>

            <div id="forgot-password-container" class="space-y-4 hidden">
                <form id="forgot-password-form" method="POST" action="{{ route('requestOtp') }}" class="space-y-4">
                    @csrf
                    <input type="email" name="email" id="forgot-password-email" placeholder="Email Address" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white btn-password-change bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                        SEND RESET CODE
                    </button>
                </form>

                <div class="my-6 border-t border-neutral pt-4">
                    <button type="button" onclick="setActiveView('signin')" class="text-sm font-poppins text-sky hover:text-dark transition-default">
                        Already have an account? <strong class="underline">Sign In</strong>
                    </button>
                </div>
            </div>

            <div id="otp-verify-container" class="space-y-4 hidden">
                <form id="otp-verify-form" method="POST" action="{{ route('verifyOtp') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="email" id="otp-verify-email" class="focus:outline-sky">
                    <input type="text" name="otp" placeholder="Enter OTP" required class="w-full border border-neutral rounded-lg p-2">
                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                        VERIFY CODE
                    </button>
                </form>

                <button type="button" onclick="setActiveView('forgot-password')" class="text-sm font-poppins text-sakura hover:text-dark transition-default">
                    Resend Code
                </button>
            </div>

            <div id="reset-password-container" class="space-y-4 hidden">
                <form id="reset-password-form" method="POST" action="{{ route('resetPassword') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="reset_token" id="reset-token-input" class="focus:outline-sky">
                    <div class="relative mb-4">
                        <input type="password" name="password" id="reset-new-password" placeholder="New Password (min 8 chars)" required class="w-full border border-neutral rounded-lg p-2 pr-10 focus:outline-sky">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('reset-new-password')">
                            <i class="far fa-eye" id="toggle-reset-new-password"></i>
                        </span>
                    </div>
                    <div id="reset-new-password-error" class="text-sakura text-sm text-left -mt-3 mb-3"></div>
                    <div class="relative mb-4">
                        <input type="password" name="password_confirmation" id="reset-confirm-password" placeholder="Confirm Password" required class="w-full border border-neutral rounded-lg p-2 pr-10 focus:outline-sky">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" onclick="togglePasswordVisibility('reset-confirm-password')">
                            <i class="far fa-eye" id="toggle-reset-confirm-password"></i>
                        </span>
                    </div>
                    <div id="reset-confirm-password-error" class="text-sakura text-sm text-left -mt-3 mb-3"></div>
                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-sakura hover:bg-opacity-90 transition-default shadow-soft">
                        CHANGE PASSWORD
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        let resetEmail = '';

        function setActiveView(view, event = null) {
            if (event) event.preventDefault();
            
            const signIn = document.getElementById('signin-form-container');
            const signUp = document.getElementById('signup-form-container');
            const forgotPassword = document.getElementById('forgot-password-container');
            const otpContainer = document.getElementById('otp-verify-container');
            const resetPassword = document.getElementById('reset-password-container');
            
            const authTitle = document.getElementById('auth-title');
            const authMessage = document.getElementById('auth-message');
            const status = document.getElementById('auth-status-message');

            const forms = [
                document.getElementById('signin-form'),
                document.getElementById('signup-form'),
                document.getElementById('forgot-password-form'),
                document.getElementById('otp-verify-form'),
                document.getElementById('reset-password-form')
            ];
            forms.forEach(form => form?.reset());

            const errorMessages = document.querySelectorAll('[id$="-error"]');
            errorMessages.forEach(el => el.textContent = '');

            signIn.classList.add('hidden');
            signUp.classList.add('hidden');
            forgotPassword.classList.add('hidden');
            otpContainer.classList.add('hidden');
            resetPassword.classList.add('hidden'); 

            let titleText = '';
            let messageText = 'Please sign in or sign up to continue.';

            if (view === 'signup') {
                signUp.classList.remove('hidden');
                titleText = 'Create Your Bloombeads Account';
            } else if (view === 'forgot-password') {
                forgotPassword.classList.remove('hidden');
                titleText = 'Reset Your Password';
                messageText = 'Enter your email to send the code.';
            } else if (view === 'otp') {
                otpContainer.classList.remove('hidden');
                titleText = 'Verify Code';
                messageText = 'Enter the OTP sent to ' + resetEmail + '.';
                document.getElementById('otp-verify-email').value = resetEmail;
            } else if (view === 'reset') {
                resetPassword.classList.remove('hidden');
                titleText = 'Set New Password';
                messageText = 'Enter your new password.';
            } else {
                signIn.classList.remove('hidden');
                titleText = 'Welcome Back! Sign In';
            }
            
            authTitle.textContent = titleText;
            authMessage.textContent = messageText;
        }

        function showMessage(message, colorClass = '') {
            const status = document.getElementById('auth-status-message');
            status.className = `h-6 font-poppins text-sm mb-4 text-center ${colorClass}`;
            status.textContent = message;
            console.error(message);

            setTimeout(() => {
                status.textContent = '';
                status.className = 'h-6 font-poppins text-sm mb-4 text-center';
            }, 3000);
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

        document.addEventListener('DOMContentLoaded', () => {
            
            const hasSignupErrors = {!! $errors->any() && (old('firstName') || old('lastName') || old('password') || old('contact_number') || old('address')) ? 'true' : 'false' !!};
            if (hasSignupErrors) {
                setActiveView('signup');
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            const signupForm = document.getElementById('signup-form');
            if (signupForm) {
                const firstName = document.getElementById('firstName');
                const lastName = document.getElementById('lastName');
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                const passwordConfirm = document.getElementById('password_confirmation');
                const contactNumber = document.getElementById('contact_number');
                const address = document.getElementById('address');

                const firstNameError = document.getElementById('firstName-error');
                const lastNameError = document.getElementById('lastName-error');
                const emailError = document.getElementById('email-error');
                const passwordError = document.getElementById('password-error');
                const passwordConfirmError = document.getElementById('password_confirmation-error');
                const contactNumberError = document.getElementById('contact_number-error');
                const addressError = document.getElementById('address-error');

                const nameRegex = /^[a-zA-Z\s]+$/;
                const phoneRegex = /^(\+63|0)9\d{9}$/;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                const setError = (el, message) => {
                    if (el) el.textContent = message;
                };

                firstName.addEventListener('input', () => {
                    if (firstName.value.trim() === '') {
                        setError(firstNameError, 'First name is required.');
                    } else if (!nameRegex.test(firstName.value)) {
                        setError(firstNameError, 'First name must contain letters only.');
                    } else {
                        setError(firstNameError, '');
                    }
                });

                lastName.addEventListener('input', () => {
                    if (lastName.value.trim() === '') {
                        setError(lastNameError, 'Last name is required.');
                    } else if (!nameRegex.test(lastName.value)) {
                        setError(lastNameError, ' name must contain letters only.');
                    } else {
                        setError(lastNameError, '');
                    }
                });

                email.addEventListener('input', () => {
                    if (email.value.trim() === '') {
                        setError(emailError, 'Email is required.');
                    } else if (!emailRegex.test(email.value)) {
                        setError(emailError, 'Please enter a valid email format.');
                    } else if (!email.value.endsWith('@gmail.com')) {
                        setError(emailError, 'Email must end at @gmail.com.');
                    } else {
                        setError(emailError, '');
                    }
                });

                password.addEventListener('input', () => {
                    const val = password.value;
                    let errors = [];
                    if (val.length < 8) errors.push('at least 8 characters');
                    if (!/[A-Z]/.test(val)) errors.push('1 uppercase letter');
                    if (!/\d/.test(val)) errors.push('1 number');
                    if (!/[!@#$%^&*()]/.test(val)) errors.push('1 special character');

                    if (errors.length > 0) {
                        setError(passwordError, 'Password must contain: ' + errors.join(', ') + '.');
                    } else {
                        setError(passwordError, '');
                    }
                    if (passwordConfirm.value !== '') {
                        if (password.value !== passwordConfirm.value) {
                            setError(passwordConfirmError, 'Passwords do not match.');
                        } else {
                            setError(passwordConfirmError, '');
                        }
                    }
                });

                passwordConfirm.addEventListener('input', () => {
                    if (passwordConfirm.value === '') {
                        setError(passwordConfirmError, 'Please confirm your password.');
                    } else if (password.value !== passwordConfirm.value) {
                        setError(passwordConfirmError, 'Passwords do not match.');
                    } else {
                        setError(passwordConfirmError, '');
                    }
                });

                contactNumber.addEventListener('input', () => {
                    if (contactNumber.value.trim() === '') {
                        setError(contactNumberError, 'Phone number is required.');
                    } else if (!phoneRegex.test(contactNumber.value)) {
                        setError(contactNumberError, 'Must be a valid Philippine number (e.g., 09xxxxxxxxx).');
                    } else {
                        setError(contactNumberError, '');
                    }
                });

                address.addEventListener('input', () => {
                    if (address.value.trim() === '') {
                        setError(addressError, 'Address must be filled.');
                    } else {
                        setError(addressError, '');
                    }
                });
            }
            
            const forgotPasswordForm = document.getElementById('forgot-password-form');
            if (forgotPasswordForm) {
                forgotPasswordForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(forgotPasswordForm);
                    const emailInput = document.getElementById('forgot-password-email');
                    resetEmail = emailInput.value;

                    try {
                        const response = await fetch(forgotPasswordForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken || formData.get('_token')
                            },
                            body: formData,
                            credentials: 'same-origin'
                        });

                        const isJson = response.headers.get('content-type')?.includes('application/json');
                        const data = isJson ? await response.json() : {};

                        if (response.ok) {
                            showMessage(data.message || 'OTP sent! Please check your email.', 'text-green-600');
                            setActiveView('otp');
                        } else {
                            const message = data.message || (response.status === 422 ? 'Invalid email format.' : 'Failed to send OTP. Check console.');
                            showMessage(message, 'text-sakura');
                            if (!isJson) {
                                showMessage('Server error — try again. Check console for details.', 'text-sakura');
                                console.error('OTP request failed', response.status, await response.text());
                            }
                        }
                    } catch (err) {
                        console.error('OTP request error:', err);
                        showMessage('Network error while requesting OTP.', 'text-sakura');
                    }
                });
            }

            const otpVerifyForm = document.getElementById('otp-verify-form');
            if (otpVerifyForm) {
                otpVerifyForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(otpVerifyForm);

                    try {
                        const response = await fetch(otpVerifyForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken || formData.get('_token')
                            },
                            body: formData,
                            credentials: 'same-origin'
                        });

                        const isJson = response.headers.get('content-type')?.includes('application/json');
                        const data = isJson ? await response.json() : {};

                        if (response.ok && data.reset_token) {
                            showMessage('Code verified! Set your new password.', 'text-green-600');
                            document.getElementById('reset-token-input').value = data.reset_token;
                            setActiveView('reset'); 
                        } else {
                            const message = data.message || (response.status === 422 ? 'Invalid or expired code.' : 'Verification failed. Check console.');
                            showMessage(message, 'text-sakura');
                            if (!isJson) console.error('OTP verification failed', response.status, await response.text());
                        }
                    } catch (err) {
                        console.error('OTP verification error:', err);
                        showMessage('Network error during OTP verification.', 'text-sakura');
                    }
                });
            }

            const resetPasswordForm = document.getElementById('reset-password-form');
            if (resetPasswordForm) {
                resetPasswordForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(resetPasswordForm);

                    try {
                        const response = await fetch(resetPasswordForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken || formData.get('_token')
                            },
                            body: formData,
                            credentials: 'same-origin'
                        });

                        const isJson = response.headers.get('content-type')?.includes('application/json');
                        const data = isJson ? await response.json() : {};

                        if (response.ok) {
                            showMessage(data.message || 'Password successfully changed!', 'text-green-600');
                            setActiveView('signin');
                        } else {
                            const message = data.message || (response.status === 422 ? 'Password validation failed.' : 'Reset failed. Check console.');
                            showMessage(message, 'text-sakura');
                            if (!isJson) console.error('Password reset failed', response.status, await response.text());
                        }
                    } catch (err) {
                        console.error('Password reset error:', err);
                        showMessage('Network error during password reset.', 'text-sakura');
                    }
                });
            }
        });
    </script>
</x-layout>