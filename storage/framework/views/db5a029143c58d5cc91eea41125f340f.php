<?php if (isset($component)) { $__componentOriginalc271fb81a8689e34c76ac4563e9c3dba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc271fb81a8689e34c76ac4563e9c3dba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.format','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('format'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalfd1f218809a441e923395fcbf03e4272 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfd1f218809a441e923395fcbf03e4272 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfd1f218809a441e923395fcbf03e4272)): ?>
<?php $attributes = $__attributesOriginalfd1f218809a441e923395fcbf03e4272; ?>
<?php unset($__attributesOriginalfd1f218809a441e923395fcbf03e4272); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfd1f218809a441e923395fcbf03e4272)): ?>
<?php $component = $__componentOriginalfd1f218809a441e923395fcbf03e4272; ?>
<?php unset($__componentOriginalfd1f218809a441e923395fcbf03e4272); ?>
<?php endif; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php echo e($slot); ?>

    </main>

    <footer class="bg-[#CFE7FF] mt-20">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-10 py-10 md:px-0">
            
            <div class="text-center md:text-left md:mb-0">
                <h1 class="text-5xl font-fredoka font-bold text-[#F77AA6]">BloombeadsbyJinx</h1>
            </div>

            <div class="text-center md:text-right">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Visit us on</h2>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://facebooklink.com" class="text-gray-800 hover:underline">https://facebooklink.com//</a>
                        <span class="bg-[#F77AA6] text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-facebook" class="w-4 h-4"></i>
                        </span>
                    </li>
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://instagramlink.com" class="text-gray-800 hover:underline">https://instagramlink.com//</a>
                        <span class="bg-[#F77AA6] text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-instagram" class="w-4 h-4"></i>
                        </span>
                    </li>
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://tiktoklink.com" class="text-gray-800 hover:underline">https://tiktoklink.com//</a>
                        <span class="bg-[#F77AA6] text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-tiktok" class="w-4 h-4"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

        <div class="text-center py-3 border-t border-gray-200 text-sm text-gray-600">
            ©2025 Bloombeads. All Rights Reserved.
        </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc271fb81a8689e34c76ac4563e9c3dba)): ?>
<?php $attributes = $__attributesOriginalc271fb81a8689e34c76ac4563e9c3dba; ?>
<?php unset($__attributesOriginalc271fb81a8689e34c76ac4563e9c3dba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc271fb81a8689e34c76ac4563e9c3dba)): ?>
<?php $component = $__componentOriginalc271fb81a8689e34c76ac4563e9c3dba; ?>
<?php unset($__componentOriginalc271fb81a8689e34c76ac4563e9c3dba); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\Jan\bloombeads_ecommercewebsite\resources\views/components/layout.blade.php ENDPATH**/ ?>