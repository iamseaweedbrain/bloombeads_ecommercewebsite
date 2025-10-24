function toggleAuthView(view) {
    const signIn = document.getElementById('signin-form-container');
    const signUp = document.getElementById('signup-form-container');
    const authTitle = document.getElementById('auth-title');
    const status = document.getElementById('auth-status-message');

    if (view === 'signup') {
        signIn.classList.add('hidden');
        signUp.classList.remove('hidden');
        authTitle.textContent = 'Create Your Bloombeads Account';
    } else {
        signIn.classList.remove('hidden');
        signUp.classList.add('hidden');
        authTitle.textContent = 'Welcome Back! Sign In';
    }
    status.textContent = '';
}


function showMessage(message, colorClass) {
    const status = document.getElementById('auth-status-message');
    status.className = `h-6 font-poppins text-sm mb-4 text-center ${colorClass}`;
    status.innerHTML = message;

    setTimeout(() => {
        status.textContent = '';
        status.className = 'h-6 font-poppins text-sm mb-4 text-center';
    }, 3000);
}

window.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signup-form');
    const signinForm = document.getElementById('signin-form');

    signupForm?.addEventListener('submit', (e) => {
        showMessage('<span class="font-bold">Account Created!</span> Please log in below.', 'text-sakura');
        toggleAuthView('signin');
    });
});
