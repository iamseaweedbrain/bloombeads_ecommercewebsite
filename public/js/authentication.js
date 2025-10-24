function toggleAuthView(view) {
    const signIn = document.getElementById('signin-form-container');
    const signUp = document.getElementById('signup-form-container');
    const authTitle = document.getElementById('auth-title');
    const status = document.getElementById('auth-status-message');

    const isSignup = view === 'signup';
    signIn.classList.toggle('hidden', isSignup);
    signUp.classList.toggle('hidden', !isSignup);
    authTitle.textContent = isSignup 
        ? 'Create Your Bloombeads Account' 
        : 'Welcome Back! Sign In';
    status.textContent = '';
}

function showMessage(message, colorClass = '') {
    const status = document.getElementById('auth-status-message');
    status.className = `h-6 font-poppins text-sm mb-4 text-center ${colorClass}`;
    status.textContent = message;

    setTimeout(() => {
        status.textContent = '';
        status.className = 'h-6 font-poppins text-sm mb-4 text-center';
    }, 3000);
}

document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signup-form');
    if (!signupForm) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    signupForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(signupForm);

        try {
            const response = await fetch(signupForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken || formData.get('_token')
                },
                body: formData,
                credentials: 'same-origin'
            });

            const isJson = response.headers.get('content-type')?.includes('application/json');
            const data = isJson ? await response.json() : null;

            if (response.ok) {
                showMessage(data?.message || 'Account created! Please log in.', 'text-sakura');
                toggleAuthView('signin');
            } else {
                const message = data?.message 
                    || (response.status === 422 ? 'Validation failed. Check your inputs.' : 'Signup failed. See console for details.');
                showMessage(message, 'text-sakura');

                if (!data) console.error('Signup failed', response.status, await response.text());
            }
        } catch (err) {
            console.error('Signup request error:', err);
            showMessage('Network error while signing up.', 'text-sakura');
        }
    });
});
