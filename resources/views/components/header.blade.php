<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sakura: '#FF6B81', sky: '#48DBFB', cta: '#FFB347', dark: '#333333', neutral: '#F7F7F7',
                    },
                    fontFamily: {
                        fredoka: ['Fredoka', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <header class="bg-white shadow-soft sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ url('/homepage') }}" class="text-2xl font-fredoka font-bold text-sakura hover:text-dark transition-default">
                    Bloombeads
                </a>

                <nav class="hidden md:flex space-x-8 font-poppins">
                    <a href="{{ url('/homepage') }}" class="text-dark hover:text-sakura">Home</a>
                    <a href="{{ url('/browsecatalog') }}" class="text-dark hover:text-sakura">Browse Catalogue</a>
                    <a href="{{ url('/customize') }}" class="text-dark hover:text-sakura">Design Yours</a>
                    <a href="{{ url('/support') }}" class="text-dark hover:text-sakura">Help & FAQs</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="{{ url('/settings') }}" title="Settings"><i data-lucide="settings" class="w-6 h-6 text-dark hover:text-sakura"></i></a>
                    <a href="{{ url('/cart') }}" title="View Cart"><i data-lucide="shopping-cart" class="w-6 h-6 text-dark hover:text-sakura"></i></a>
                    <a href="{{ url('/dashboard') }}" title="Dashboard"><i data-lucide="user" class="w-6 h-6 text-dark hover:text-sakura"></i></a>

                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden');" class="md:hidden text-dark hover:text-sakura">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 font-poppins">
                <a href="{{ url('/browsecatalog') }}" class="block px-3 py-2 hover:text-sakura">Browse Catalogue</a>
                <a href="{{ url('/customize') }}" class="block px-3 py-2 hover:text-sakura">Design Yours</a>
                <a href="{{ url('/support') }}" class="block px-3 py-2 hover:text-sakura">Help & FAQs</a>
                <a href="{{ url('/settings') }}" class="block px-3 py-2 hover:text-sakura">Settings</a>
                <a href="{{ url('/dashboard') }}" class="block px-3 py-2 hover:text-sakura">Account / Sign In</a>
            </div>
        </div>
    </header>

    {{ $slot }}

</body>
</html>