<x-layout>
    <section id="auth-view" class="py-12 md:py-24">
        <div class="max-w-md mx-auto bg-white card-radius shadow-soft p-8 text-center">
            <!-- Title -->
            <h2 id="auth-title" class="text-3xl font-fredoka font-bold text-dark mb-6 border-b pb-3 border-neutral">
                Welcome Back! Sign In
            </h2>

            <!-- Message -->
            <div id="auth-message" class="text-sm font-poppins text-sakura mb-4">
                Please sign in or sign up to continue.
            </div>

            <!-- Status Message (flash or errors) -->
            <div id="auth-status-message" class="h-6 font-poppins text-sm mb-4 text-center">
                @if(session('login_error'))
                    {{ session('login_error') }}
                @endif
            </div>

            <!-- Sign In Form -->
            <div id="signin-form-container" class="space-y-4">
                <form id="signin-form" method="POST" action="{{ route('auth.login') }}" class="space-y-4">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address" required class="w-full border border-neutral rounded-lg p-2">
                    <input type="password" name="password" placeholder="Password" required class="w-full border border-neutral rounded-lg p-2">
                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                        LOG IN
                    </button>
                </form>

                <a href="#" onclick="setActiveView('forgot-password', event)" class="block mt-4 text-sm font-poppins text-sky hover:text-dark transition-default">
                    Forgot Password?
                </a>

                <div class="my-6 border-t border-neutral pt-4">
                    <button type="button" onclick="toggleAuthView('signup')" class="text-sm font-poppins text-sakura hover:text-dark transition-default">
                        Don't have an account? <strong class="underline">Sign Up Here</strong>
                    </button>
                </div>
            </div>

            <!-- Sign Up Form -->
            <div id="signup-form-container" class="space-y-4 hidden">
                <form id="signup-form" method="POST" action="{{ route('auth.signup') }}" class="space-y-4">
                    @csrf
                    <input type="text" name="fullName" placeholder="Full Name" required class="w-full border border-neutral rounded-lg p-2">
                    <input type="email" name="email" placeholder="Email Address" required class="w-full border border-neutral rounded-lg p-2">
                    <input type="password" name="password" placeholder="Create Password" required class="w-full border border-neutral rounded-lg p-2">
                    <button type="submit" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-sakura hover:bg-opacity-90 transition-default shadow-soft">
                        SIGN UP
                    </button>
                </form>

                <div class="my-6 border-t border-neutral pt-4">
                    <button type="button" onclick="toggleAuthView('signin')" class="text-sm font-poppins text-sky hover:text-dark transition-default">
                        Already have an account? <strong class="underline">Sign In</strong>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Link Authentication JS -->
    <script src="{{ asset('js/authentication.js') }}"></script>

    <!-- Flash Messages after Signup -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                toggleAuthView('signin');
                showMessage("{{ session('success') }}", "text-sakura");
            });
            document.getElementById('signup-form').addEventListener('submit', function(e) {
                e.preventDefault(); // prevent default
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': formData.get('_token') }
                }).then(res => res.text()).then(console.log);
            });

        </script>
    @endif
</x-layout>
