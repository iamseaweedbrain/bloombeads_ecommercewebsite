<x-layout>
    <section id="home-view" class="py-12 md:py-16">
        <!-- Hero Section -->
            <div id="home-hero" class="pb-16 pt-0 md:py-24 text-center">
                <div class="bg-white card-radius shadow-soft p-8 md:p-16 relative overflow-hidden">
                    <div class="absolute inset-0 bg-sakura opacity-10"></div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-fredoka font-bold mb-4 relative z-1">
                        Your Vibe, Your Beads: Custom Beaded Jewelry & Anime Keychains.
                    </h1>

                    <p class="text-lg md:text-xl font-poppins text-dark mb-10 relative z-1 max-w-3xl mx-auto">
                        Craft your own custom beaded style. Handmade quality, delivered with care.
                        Find the perfect accessory to express yourself.
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 relative z-[1">
                        <a href="{{ route('customize') }}"
                        class="py-3 px-8 text-lg font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft transform hover:scale-[1.02]">
                            DESIGN YOURS
                        </a>

                        <a href="{{ route('browsecatalog') }}"
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
                            <li><strong class="text-sakura">Bead Color:</strong> Use our bead component picker to get the perfect beads for your design.</li>
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
                <img src="{{ asset('images/beaded-bracelets.jpeg') }}" 
                      alt="Beaded Bracelets" 
                       class="mx-auto mb-4 rounded-xl w-48 h-48 object-cover shadow-md">
                    <h3 class="text-xl font-fredoka font-bold text-sakura mb-2">Beaded Bracelets</h3>
                    <p class="font-poppins text-dark/80">Fully customizable designs, perfect for daily wear and fandom expression.</p>
                </div>

                    <div class="bg-white p-6 card-radius shadow-soft">
                    <img src="{{ asset('images/anime-keychains.jpeg') }}" 
                         alt="Anime Keychains" 
                         class="mx-auto mb-4 rounded-xl w-48 h-48 object-cover shadow-md">
                        <h3 class="text-xl font-fredoka font-bold text-sky mb-2">Anime Keychains</h3>
                        <p class="font-poppins text-dark/80">Exclusive, pre-designed keychains featuring your favorite anime tags and characters.</p>
                    </div>

                    <div class="bg-white p-6 card-radius shadow-soft">
                    <img src="{{ asset('images/jewelry-boxes.jpeg') }}"
                          alt="Jewelry Boxes"
                          class="mx-auto mb-4 rounded-xl w-48 h-48 object-cover shadow-md">
                        <h3 class="text-xl font-fredoka font-bold text-cta mb-2">Jewelry Boxes</h3>
                        <p class="font-poppins text-dark/80">Stylish, cozy storage for your growing collection of beads and accessories.</p>
                    </div>
                </div>
            </section>

        </section>

</x-layout>

<footer class="bg-[#CFE7FF] mt-20">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-10 py-10 md:px-0">
            
            <div class="text-center md:text-left md:mb-0">
                <h1 class="text-5xl font-fredoka font-bold text-sakura">BloombeadsbyJinx</h1>
            </div>

            <div class="text-center md:text-right">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Visit us on</h2>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://www.facebook.com/BloomcraftsbyJinx" class="text-gray-800 hover:underline">BloombeadsbyJinx</a>
                        <span class="bg-sakura text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-facebook" class="w-4 h-4"></i>
                        </span>
                    </li>
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://instagramlink.com" class="text-gray-800 hover:underline">BloombeadsbyJinx</a>
                        <span class="bg-sakura text-white rounded-full p-2 flex items-center justify-center">
                            <i class="fa-brands fa-instagram" class="w-4 h-4"></i>
                        </span>
                    </li>
                    <li class="flex items-center justify-center md:justify-end space-x-3">
                        <a href="https://www.tiktok.com/@bloombeadsbyjinx?_t=8cMAWDMNc1a&_r=1&fbclid=IwY2xjawN-lm1leHRuA2FlbQIxMABicmlkETFrVTREMWJOeEtKYTBIQU1zc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHvTwwCGdUzPV9qq1QRUZnF1GKFIgvZy_8heKBLG-6-c_dhIoPqabmSCtU8_m_aem_SqjmzOTrxRTq9-8mKJaDCg" class="text-gray-800 hover:underline">BloombeadsbyJinx</a>
                        <span class="bg-sakura text-white rounded-full p-2 flex items-center justify-center">
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