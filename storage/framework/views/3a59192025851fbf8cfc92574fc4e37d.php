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
    <section id="home-view" class="py-12 md:py-16">

            <!-- Hero Section -->
            <div id="home-hero" class="pb-16 pt-0 md:py-24 text-center">
                <div class="bg-white card-radius shadow-soft p-8 md:p-16 relative overflow-hidden">
                    <!-- Subtle background element -->
                    <div class="absolute inset-0 bg-sakura opacity-10"></div>

                    <!-- Main Heading -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-fredoka font-bold mb-4 relative z-[1]">
                        Your Vibe, Your Beads: Custom Beaded Jewelry & Anime Keychains.
                    </h1>

                    <!-- Subheading -->
                    <p class="text-lg md:text-xl font-poppins text-dark mb-10 relative z-[1] max-w-3xl mx-auto">
                        Craft your own custom beaded style. Handmade quality, delivered with care.
                        Find the perfect accessory to express yourself.
                    </p>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 relative z-[1]">
                        <!-- CTA Button -->
                        <a href="<?php echo e(route('customize')); ?>"
                        class="py-3 px-8 text-lg font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft transform hover:scale-[1.02]">
                            DESIGN YOURS
                        </a>

                        <!-- Secondary Button -->
                        <a href="<?php echo e(route('browsecatalog')); ?>"
                        class="py-3 px-8 text-lg font-fredoka font-bold card-radius text-sakura border-2 border-sakura bg-white hover:bg-sakura hover:text-white transition-default shadow-soft">
                            BROWSE CATALOGUE
                        </a>
                    </div>
                </div>
            </div>

            <!-- Customization Promise Section -->
            <section id="custom-promise" class="py-12 md:py-16 bg-white card-radius shadow-soft my-16 p-8">
                <h2 class="text-3xl font-fredoka font-bold mb-8 text-center text-sakura">
                    Your Custom Beaded Bracelet Promise
                </h2>

                <div class="md:grid md:grid-cols-2 gap-10 items-center">
                    <div class="order-2 md:order-1">
                        <p class="font-poppins text-lg mb-4">
                            We ensure every Beaded Bracelet you design is a unique reflection of your style and fandom.
                            Our tool gives you complete control over:
                        </p>

                        <ul class="list-disc list-inside space-y-2 font-poppins text-dark/80">
                            <li><strong class="text-sakura">Bead Color:</strong> Use our RGB tuner to get the perfect shade.</li>
                            <li><strong class="text-sky">Charm Selection:</strong> Choose from various shapes like Star, Heart, and Moon.</li>
                            <li><strong class="text-cta">Durable Quality:</strong> Handmade with durable cord and hypoallergenic metal findings.</li>
                        </ul>
                    </div>

                    <!-- Mock Image -->
                    <div class="order-1 md:order-2 mb-6 md:mb-0 aspect-video bg-sky/20 card-radius flex items-center justify-center shadow-soft">
                        <span id="home-preview-text" class="text-xl font-poppins text-dark/70">Custom Bracelet Tool Mockup</span>
                    </div>
                </div>
            </section>

            <!-- What Bloombeads Offers Section -->
            <section id="products-offer" class="py-12 md:py-16 bg-neutral card-radius shadow-soft p-8 border border-gray-200">
                <h2 class="text-3xl font-fredoka font-bold mb-8 text-center">
                    What Bloombeads Offers
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div class="bg-white p-6 card-radius shadow-soft">
                        <h3 class="text-xl font-fredoka font-bold text-sakura mb-2">Beaded Bracelets</h3>
                        <p class="font-poppins text-dark/80">Fully customizable designs, perfect for daily wear and fandom expression.</p>
                    </div>

                    <div class="bg-white p-6 card-radius shadow-soft">
                        <h3 class="text-xl font-fredoka font-bold text-sky mb-2">Anime Keychains</h3>
                        <p class="font-poppins text-dark/80">Exclusive, pre-designed keychains featuring your favorite anime tags and characters.</p>
                    </div>

                    <div class="bg-white p-6 card-radius shadow-soft">
                        <h3 class="text-xl font-fredoka font-bold text-cta mb-2">Jewelry Boxes</h3>
                        <p class="font-poppins text-dark/80">Stylish, cozy storage for your growing collection of beads and accessories.</p>
                    </div>
                </div>
            </section>

        </section>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\Jan\bloombeads_ecommercewebsite\resources\views/homepage.blade.php ENDPATH**/ ?>