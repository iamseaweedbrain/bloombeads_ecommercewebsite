<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'Recent Activity']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Activity']); ?>
  <div class="flex min-h-screen bg-gradient-to-br from-pink-100 via-white to-pink-50">

    <!-- Sidebar -->
    <aside class="w-80 bg-transparent text-gray-600 p-10">
      <h2 class="text-2xl font-bold text-center text-rose-600 mb-8">Account Dashboard</h2>

      <div class="bg-white rounded-2xl shadow-lg p-6 border border-pink-100">
        <nav class="space-y-3">
          <a href="<?php echo e(route('account.info')); ?>"
             class="block px-3 py-2 rounded-lg font-medium transition 
             <?php echo e(request()->routeIs('account.info') 
                ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700'); ?>">
            👤 User Information
          </a>

          <a href="<?php echo e(route('account.activity')); ?>"
             class="block px-3 py-2 rounded-lg font-medium transition 
             <?php echo e(request()->routeIs('account.activity') 
                ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700'); ?>">
            🔔 Recent Activity
          </a>

          <a href="<?php echo e(route('account.orders')); ?>"
             class="block px-3 py-2 rounded-lg font-medium transition 
             <?php echo e(request()->routeIs('account.orders') 
                ? 'bg-rose-100 text-rose-700 font-semibold shadow-sm' 
                : 'hover:bg-rose-100 hover:text-rose-700 text-gray-700'); ?>">
            🛍️ Order History
          </a>

          <br>
<form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-6">
    <?php echo csrf_field(); ?>
    <button type="submit"
        class="w-full text-left block px-4 py-2 rounded-md font-medium text-white 
               bg-orange-500 hover:bg-orange-600 
               shadow-md hover:shadow-lg transition-all duration-200">
        <span class="inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m0-8V7a2 2 0 114 0v1" />
            </svg>
            Log Out
        </span>
    </button>
</form>
        </nav>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
      <h1 class="text-3xl font-bold text-rose-600 mb-8">Recent Activity</h1>

      <!-- Recent Activity Box -->
      <div class="bg-white p-8 rounded-2xl shadow-lg border border-pink-100 max-w-3xl">
        <div class="border-b border-pink-200 pb-3 mb-5">
          <h2 class="text-lg font-semibold text-rose-600">Recent Activity</h2>
        </div>

        <div class="space-y-4">
          <!-- Activity 1 -->
          <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:bg-pink-50 transition">
            <p class="text-gray-800 font-medium">
              Saved new Custom Bracelet Design: 
              <span class="text-rose-600 font-semibold">"Moonlit Dragon"</span>
            </p>
            <p class="text-sm text-gray-500 mt-1">1 hour ago</p>
          </div>

          <!-- Activity 2 -->
          <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:bg-pink-50 transition">
            <p class="text-gray-800 font-medium">
              Placed Order 
              <span class="text-rose-600 font-semibold">#BB1025-001</span> ($98.00)
            </p>
            <p class="text-sm text-gray-500 mt-1">Yesterday</p>
          </div>

          <!-- Activity 3 -->
          <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:bg-pink-50 transition">
            <p class="text-gray-800 font-medium">
              Viewed product: 
              <span class="text-rose-600 font-semibold">Kawaii Jewelry Box</span>
            </p>
            <p class="text-sm text-gray-500 mt-1">3 days ago</p>
          </div>
        </div>
      </div>
    </main>

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
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Jan\bloombeads_ecommercewebsite\resources\views/account/activity.blade.php ENDPATH**/ ?>