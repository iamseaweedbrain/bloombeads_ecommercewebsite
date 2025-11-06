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
                
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('settings')); ?>" title="Settings">
                        <i data-lucide="settings" class="w-6 h-6 text-dark hover:text-sakura"></i>
                    </a>

                    <a href="<?php echo e(route('cart')); ?>" title="View Cart" class="relative">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-dark hover:text-sakura"></i>
                        <span id="cart-badge" 
                              class="absolute -top-2 -right-3 bg-sakura text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center
                              <?php echo e($cartTotalQuantity > 0 ? '' : 'hidden'); ?>">
                            <?php echo e($cartTotalQuantity); ?>

                        </span>
                    </a>

                    <a href="<?php echo e(route('dashboard')); ?>" title="Dashboard">
                        <i data-lucide="user" class="w-6 h-6 text-dark hover:text-sakura"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('auth.page')); ?>" class="font-poppins text-dark hover:text-sakura font-medium">
                        Login / Sign Up
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
            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('settings')); ?>" class="block px-3 py-2 hover:text-sakura">Settings</a>
                <a href="<?php echo e(route('cart')); ?>" class="block px-3 py-2 hover:text-sakura">Cart</a>
                <a href="<?php echo e(route('dashboard')); ?>" class="block px-3 py-2 hover:text-sakura">Account</a>
            <?php else: ?>
                <a href="<?php echo e(route('auth.page')); ?>" class="block px-3 py-2 hover:text-sakura font-medium">Login / Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\Users\Maxine\Herd\bloombeads_website\resources\views/components/header.blade.php ENDPATH**/ ?>