<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-white min-h-screen text-gray-800">
    <!-- Header -->
    <header class="flex items-center justify-between px-10 py-4 border-b shadow-sm">
        <h1 class="text-2xl font-extrabold text-pink-500">Bloombeads</h1>
        <nav class="space-x-6 text-gray-700 font-medium">
            <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-pink-500">Dashboard</a>
            <a href="<?php echo e(route('logout')); ?>" class="hover:text-pink-500">Logout</a>
        </nav>
    </header>

    <div class="max-w-3xl mx-auto mt-10">
        <h2 class="text-3xl font-bold text-gray-700 mb-6">Account Settings</h2>

        <!-- Success / Error Messages -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <!-- PROFILE UPDATE FORM -->
        <div class="bg-gray-50 p-6 rounded-2xl shadow mb-8">
            <h3 class="text-xl font-semibold mb-4 text-pink-500">Profile Information</h3>

            <form method="POST" action="<?php echo e(route('settings')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" name="fullName" value="<?php echo e(old('fullName', session('user')->fullName ?? '')); ?>" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', session('user')->email ?? '')); ?>" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Phone (optional)</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', session('user')->phone ?? '')); ?>" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Birthday (optional)</label>
                    <input type="date" name="birthday" value="<?php echo e(old('birthday', session('user')->birthday ?? '')); ?>" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <button type="submit" 
                    class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-5 py-2 rounded-lg transition">
                    Update Profile
                </button>
            </form>
        </div>

        <!-- PASSWORD UPDATE FORM -->
        <div class="bg-gray-50 p-6 rounded-2xl shadow">
            <h3 class="text-xl font-semibold mb-4 text-pink-500">Change Password</h3>

            <form method="POST" action="<?php echo e(route('settings')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Current Password</label>
                    <input type="password" name="current_password" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">New Password</label>
                    <input type="password" name="new_password" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-pink-400">
                </div>

                <button type="submit" 
                    class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-5 py-2 rounded-lg transition">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\Users\Maxine\Herd\bloombeads_website\resources\views/settings.blade.php ENDPATH**/ ?>