<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'My Account'); ?> - Bloombeads</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Custom Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sakura: 'var(--color-sakura)',
                        sky: 'var(--color-sky)',
                        cta: 'var(--color-cta)',
                        dark: 'var(--color-dark)',
                        neutral: 'var(--color-neutral)',
                        success: 'var(--color-success)',
                    },
                    fontFamily: {
                        fredoka: ['Fredoka', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-100 via-white to-pink-50 font-poppins">

    <!-- 🌸 Top Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Bloombeads Logo" class="w-8 h-8">
                <h1 class="text-2xl font-fredoka font-bold text-sakura">Bloombeads</h1>
            </div>

            <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
                <a href="<?php echo e(route('homepage')); ?>" class="hover:text-sakura transition">Home</a>
                <a href="<?php echo e(route('browsecatalog')); ?>" class="hover:text-sakura transition">Shop</a>
                <a href="<?php echo e(route('customize')); ?>" class="hover:text-sakura transition">Customize</a>
                <a href="<?php echo e(route('support')); ?>" class="hover:text-sakura transition">Support</a>
            </nav>

            <!-- User Dropdown -->
            <div class="relative">
                <button id="userMenuButton" class="flex items-center space-x-2 bg-sakura/10 px-3 py-2 rounded-lg hover:bg-sakura/20 transition">
                    <span class="text-dark font-semibold"><?php echo e(Auth::user()->name ?? 'User'); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-lg shadow-lg">
                    <a href="<?php echo e(route('account.dashboard')); ?>" class="block px-4 py-2 hover:bg-pink-100">Dashboard</a>
                    <a href="<?php echo e(route('account.info')); ?>" class="block px-4 py-2 hover:bg-pink-100">Profile</a>
                    <a href="<?php echo e(route('account.orders')); ?>" class="block px-4 py-2 hover:bg-pink-100">Orders</a>

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-pink-100">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- 🌷 Page Content -->
    <main class="max-w-7xl mx-auto p-6 md:p-10">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- 💫 Footer -->
    <footer class="text-center text-gray-500 py-6 mt-10 border-t border-pink-100">
        <p class="font-poppins">&copy; <?php echo e(date('Y')); ?> Bloombeads. All rights reserved.</p>
    </footer>

    <!-- Toggle User Menu Script -->
    <script>
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');
        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });
        window.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Jan\bloombeads_ecommercewebsite\resources\views/layouts/account.blade.php ENDPATH**/ ?>