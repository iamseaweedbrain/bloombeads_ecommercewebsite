<header class="bg-white shadow-soft sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('homepage') }}" class="text-2xl font-fredoka font-bold text-sakura hover:text-dark transition-default">
                Bloombeads
            </a>

            <nav class="hidden md:flex space-x-8 font-poppins">
                <a href="{{ route('homepage') }}" class="text-dark hover:text-sakura">Home</a>
                <a href="{{ route('browsecatalog') }}" class="text-dark hover:text-sakura">Browse Catalogue</a>
                <a href="{{ route('customize') }}" class="text-dark hover:text-sakura">Design Yours</a>
                <a href="{{ route('support') }}" class="text-dark hover:text-sakura">Help & FAQs</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="{{ route('settings') }}" title="Settings">
                    <i data-lucide="settings" class="w-6 h-6 text-dark hover:text-sakura"></i>
                </a>
                <a href="{{ route('cart') }}" title="View Cart">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-dark hover:text-sakura"></i>
                </a>
                    @if (Session::has('user'))
                        <a href="{{ route('account.dashboard') }}" title="Dashboard">
                            <i data-lucide="user" class="w-6 h-6 text-dark hover:text-sakura"></i>
                        </a>
                    @else
                        <a href="{{ route('auth.page') }}" title="Sign In">
                            <i data-lucide="log-in" class="w-6 h-6 text-dark hover:text-sakura"></i>
                        </a>
                    @endif
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden');" class="md:hidden text-dark hover:text-sakura">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 font-poppins">
            <a href="{{ route('browsecatalog') }}" class="block px-3 py-2 hover:text-sakura">Browse Catalogue</a>
            <a href="{{ route('customize') }}" class="block px-3 py-2 hover:text-sakura">Design Yours</a>
            <a href="{{ route('support') }}" class="block px-3 py-2 hover:text-sakura">Help & FAQs</a>
            <a href="{{ route('settings') }}" class="block px-3 py-2 hover:text-sakura">Settings</a>
            <a href="{{ route('cart') }}" class="block px-3 py-2 hover:text-sakura">Cart</a>
            @if (Session::has('user'))
                <a href="{{ route('account.dashboard') }}" title="Dashboard"class="block px-3 py-2 hover:text-sakura">Account</a>
            @else
                <a href="{{ route('auth.page') }}" title="Sign In"class="block px-3 py-2 hover:text-sakura">Sign In</a>
            @endif
        </div>
    </div>
</header>