<header class="bg-white shadow-soft sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?php echo e(route('homepage')); ?>" class="text-2xl font-fredoka font-bold text-sakura hover:text-dark transition-default">
                Bloombeads
            </a>

            <nav class="hidden md:flex space-x-8 font-poppins">
                <a href="<?php echo e(route('homepage')); ?>" class="text-dark hover:text-sakura">Home</a>
                <a href="<?php echo e(route('browsecatalog')); ?>" class="text-dark hover:text-sakura">Browse Catalogue</a>
                <a href="<?php echo e(route('customize')); ?>" class="text-dark hover:text-sakura">Design Yours</a>
                <a href="<?php echo e(route('support')); ?>" class="text-dark hover:text-sakura">Help & FAQs</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('settings')); ?>" title="Settings">
                    <i data-lucide="settings" class="w-6 h-6 text-dark hover:text-sakura"></i>
                </a>
                <a href="<?php echo e(route('cart')); ?>" title="View Cart">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-dark hover:text-sakura"></i>
                </a>
                    <?php if(Session::has('user')): ?>
                        <a href="<?php echo e(route('account.dashboard')); ?>" title="Dashboard">
                            <i data-lucide="user" class="w-6 h-6 text-dark hover:text-sakura"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('auth.page')); ?>" title="Sign In">
                            <i data-lucide="log-in" class="w-6 h-6 text-dark hover:text-sakura"></i>
                        </a>
                    <?php endif; ?>
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden');" class="md:hidden text-dark hover:text-sakura">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
    </div>

    
    <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 font-poppins">
            <a href="<?php echo e(route('browsecatalog')); ?>" class="block px-3 py-2 hover:text-sakura">Browse Catalogue</a>
            <a href="<?php echo e(route('customize')); ?>" class="block px-3 py-2 hover:text-sakura">Design Yours</a>
            <a href="<?php echo e(route('support')); ?>" class="block px-3 py-2 hover:text-sakura">Help & FAQs</a>
            <a href="<?php echo e(route('settings')); ?>" class="block px-3 py-2 hover:text-sakura">Settings</a>
            <a href="<?php echo e(route('cart')); ?>" class="block px-3 py-2 hover:text-sakura">Cart</a>
            <?php if(Session::has('user')): ?>
                <a href="<?php echo e(route('account.dashboard')); ?>" title="Dashboard"class="block px-3 py-2 hover:text-sakura">Account</a>
            <?php else: ?>
                <a href="<?php echo e(route('auth.page')); ?>" title="Sign In"class="block px-3 py-2 hover:text-sakura">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</header><?php /**PATH C:\xampp\htdocs\Jan\bloombeads_ecommercewebsite\resources\views/components/header.blade.php ENDPATH**/ ?>