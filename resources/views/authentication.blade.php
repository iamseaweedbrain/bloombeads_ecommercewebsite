<x-layout>
    <section id="auth-view" class="py-12 md:py-24">
        <div class="max-w-md mx-auto bg-white card-radius shadow-soft p-8 text-center">
            <h2 id="auth-title" class="text-3xl font-fredoka font-bold text-dark mb-6 border-b pb-3 border-neutral">
                Welcome Back! Sign In
            </h2>

            <div id="auth-message" class="text-sm font-poppins text-sakura mb-4">
                Please sign in or sign up to continue.
            </div>

            <div id="auth-status-message" class="h-6 font-poppins text-sm mb-4 text-center">
                @if(session('success'))
                    {{ session('success') }}
                @endif
                @if(session('error'))
                    {{ session('error') }}
                @endif
            </div>

            <div id="signin-form-container" class="space-y-4">
                <form id="signin-form" method="POST" action="{{ route('auth.login') }}" class="space-y-4">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <input type="password" name="password" placeholder="Password" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
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
                <form id="signup-form" method="POST" action="{{ route('auth.signup') }}" class="space-y-4">
                    @csrf
                    <input type="text" name="fullName" placeholder="Full Name" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <input type="email" name="email" placeholder="Email Address" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <input type="password" name="password" placeholder="Create Password" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <input type="number" name="contact_number" placeholder="Phone Number" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <input type="text" name="address" placeholder="Home Address" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
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
                    <input type="password" name="password" placeholder="New Password (min 8 chars)" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="w-full border border-neutral rounded-lg p-2 focus:outline-sky">
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

            signIn.classList.add('hidden');
            signUp.classList.add('hidden');
            forgotPassword.classList.add('hidden');
            otpContainer.classList.add('hidden');
            resetPassword.classList.add('hidden'); // Hide new container

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
            status.textContent = ''; 
        }

        function showMessage(message, colorClass = '') {
            const status = document.getElementById('auth-status-message');
            status.className = `h-6 font-poppins text-sm mb-4 text-center ${colorClass}`;
            status.textContent = message;
            console.error(message);

            // Clear status message after 3 seconds
            setTimeout(() => {
                status.textContent = '';
                status.className = 'h-6 font-poppins text-sm mb-4 text-center';
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const signupForm = document.getElementById('signup-form');
            if (signupForm) {
                signupForm.addEventListener('submit', async (e) => {
                   // e.preventDefault();
                    const formData = new FormData(signupForm);
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
                            showMessage(data.message || 'OTP sent! Please check your email.', 'text-cta');
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
                            showMessage('Code verified! Set your new password.', 'text-cta');
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
                            showMessage(data.message || 'Password successfully changed!', 'text-cta');
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