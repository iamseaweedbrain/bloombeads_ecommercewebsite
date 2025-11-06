<?php $__env->startSection('content'); ?>
<section id="notifications-view">
    <h2 class="text-3xl font-fredoka font-bold mb-6">Notifications & Logs</h2>

    <div class="bg-white card-radius shadow-soft p-6">
        <div class="space-y-3 font-poppins">
            <div class="p-3 bg-neutral card-radius border border-gray-200">
                <p><span class="font-bold text-sky">INFO:</span> Order #BB1025-002 status changed to SHIPPED. (10 min ago)</p>
            </div>
            <div class="p-3 bg-neutral card-radius border border-gray-200">
                <p><span class="font-bold text-cta">WARN:</span> Low Stock Alert for 'Kawaii Jewelry Box' (30 remaining). (1 hour ago)</p>
            </div>
            <div class="p-3 bg-neutral card-radius border border-gray-200">
                <p><span class="font-bold text-sakura">ERROR:</span> Payment failed for Order #BB1025-004. Reason: Insufficient funds. (2 hours ago)</p>
            </div>
                <div class="p-3 bg-neutral card-radius border border-gray-200">
                <p><span class="font-bold text-success">NEW:</span> New custom bracelet design 'Sakura Dream' submitted by user 'jane.doe'. (3 hours ago)</p>
            </div>
            <div class="p-3 bg-neutral card-radius border border-gray-200">
                <p><span class="font-bold text-sky">INFO:</span> Admin Seller logged in. (Yesterday)</p>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Maxine\Herd\bloombeads_website\resources\views/admin/notifications.blade.php ENDPATH**/ ?>