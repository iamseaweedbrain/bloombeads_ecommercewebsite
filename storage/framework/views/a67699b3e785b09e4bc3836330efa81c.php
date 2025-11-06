<?php $__env->startSection('content'); ?>
<section id="catalog-view">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-fredoka font-bold">Catalog Management</h2>
        <button onclick="openModal('productModal')" class="py-2 px-5 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
            Add New Product
        </button>
    </div>
    
    <?php if(session('success')): ?>
        <div class="bg-success/10 border border-success text-success p-3 rounded-lg text-center font-poppins font-semibold mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <div class="bg-white card-radius shadow-soft overflow-hidden">

    <div class="bg-white card-radius shadow-soft overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><img src="<?php echo e($product->image_path ? asset('storage/' . $product->image_path) : 'https://placehold.co/40x40/FF6B81/FFFFFF?text=B'); ?>" alt="<?php echo e($product->name); ?>" class="w-10 h-10 card-radius object-cover"></td>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->category); ?></td>
                        <td>₱<?php echo e(number_format($product->price, 2)); ?></td>
                        <td><?php echo e($product->stock); ?></td>
                        <td class="space-x-2">
                            
                            <button onclick='openEditModal(<?php echo json_encode($product, 15, 512) ?>)' class="py-1 px-3 text-xs font-poppins font-semibold card-radius text-white bg-sky hover:bg-opacity-80">
                                Edit
                            </button>

                            
                            <form action="<?php echo e(route('admin.catalog.destroy', $product->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="py-1 px-3 text-xs font-poppins font-semibold card-radius text-white bg-sakura hover:bg-opacity-80">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No products found. Add one to get started!</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
            </table>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Maxine\Herd\bloombeads_website\resources\views/admin/catalog.blade.php ENDPATH**/ ?>