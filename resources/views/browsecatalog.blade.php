<x-layout>
    @php
        $categories = [
            ['name' => 'Fashion Accessories', 'tag' => 'fashion-accessories'],
            ['name' => 'Collectibles', 'tag' => 'collectibles'],
            ['name' => 'Home Supplies', 'tag' => 'home-supplies'],
            ['name' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
        ];
        $base_price_min = 22;
        $base_price_max = 999;
        $products = [];

        // Specific JJK Products
        $specific_products = [
            ['name' => 'Geto Suguru Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/getov1.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Geto Suguru Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/getov2.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Gojo Satoru 6 Eyes Charm', 'file' => 'catalog-assets/JJK_Bagcharms/gojo6eyes.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Gojo Satoru Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/gojov2.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Gojo Satoru Charm V3', 'file' => 'catalog-assets/JJK_Bagcharms/gojov3.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Gojo Satoru Charm V4', 'file' => 'catalog-assets/JJK_Bagcharms/gojov4.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Itadori Yuji Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/itadori.jpg', 'price' => 160.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Itadori Yuji Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/itadoriv2.jpg', 'price' => 160.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Megumi Fushiguro Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/megumi.jpg', 'price' => 180.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Nanami Kento Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/nanamiv1.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Nanami Kento Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/nanamiv2.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Nobara Kugisaki Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/nobarav2.jpg', 'price' => 150.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Panda Charm', 'file' => 'catalog-assets/JJK_Bagcharms/panda.jpg', 'price' => 140.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Panda Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/pandav2.jpg', 'price' => 140.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Sukuna Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/sukunav1.jpg', 'price' => 200.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Toji Fushiguro Charm', 'file' => 'catalog-assets/JJK_Bagcharms/toji.jpg', 'price' => 220.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Yuta Okkotsu Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/yutav1.jpg', 'price' => 180.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
            ['name' => 'Yuta Okkotsu Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/yutav2.jpg', 'price' => 180.00, 'category' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
        ];
        
        $total_products_to_generate = 50;

        // --- Product Generation Logic ---
        for ($i = 1; $i <= $total_products_to_generate; $i++) {
            if ($i <= count($specific_products)) {
                // Use specific JJK product data
                $data = $specific_products[$i - 1];
        
                $productTag = $data['tag'] === 'Luggage & Bags' ? 'luggage-bags' : $data['tag']; 

                $products[] = [
                    'imagePath' => $data['file'], 
                    'name' => $data['name'], 
                    'category' => $data['category'], 
                    'price' => $data['price'], 
                    'productCategoryTag' => $productTag
                ];
            } else {
                $category_data = $categories[array_rand($categories)];
                $price = round(rand($base_price_min, $base_price_max) / 10) * 10;
                
                $products[] = [
                    'imagePath' => "https://placehold.co/400x400/96b8d4/FFFFFF?text=Item+{$i}",
                    'name' => ($i % 5 === 0) ? "Deluxe Charm Item {$i}" : "Item name {$i}",
                    'category' => $category_data['name'],
                    'price' => $price,
                    'productCategoryTag' => $category_data['tag']
                ];
            }
        }
    @endphp

    <main class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 pb-16">
        {{-- Search Bar --}}
        <div id="shop-search-bar" class="py-6">
             <input type="text" placeholder="Search product name, category, or trend..." class="w-full p-2 card-radius border border-gray-300 shadow-soft" oninput="filterProducts(selectedCategory)">
        </div>

        <section id="shop-view" class="py-4 md:py-8">
            <h2 class="text-3xl font-fredoka font-bold mb-8">Browse Catalogue</h2>
            <p class="text-dark/80 font-poppins mb-6">Find pre-made designs and inspiration for your next custom piece.</p>

            <div class="flex flex-col md:flex-row gap-8 main-content-wrapper">

                <aside class="md:w-1/4 hidden md:block sticky-filter">
                    <div class="bg-white p-6 card-radius shadow-soft sticky top-0">
                        <h3 class="text-xl font-fredoka font-bold mb-4 border-b pb-2 border-neutral">Product Filters</h3>

                        <div class="space-y-3 mb-6">
                            <h4 class="font-poppins font-semibold text-dark">Filter By Category:</h4>
                            <div class="flex flex-col gap-2">
                                <button onclick="filterProducts('all');" data-category="all" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins transition-default selected">All Products</button>
                                <button onclick="filterProducts('home-supplies');" data-category="home-supplies" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins transition-default">Home Supplies</button>
                                <button onclick="filterProducts('fashion-accessories');" data-category="fashion-accessories" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins transition-default">Fashion Accessories</button>
                                <button onclick="filterProducts('luggage-bags');" data-category="luggage-bags" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins transition-default">Luggage & Bags</button>
                                <button onclick="filterProducts('collectibles');" data-category="collectibles" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins transition-default">Collectibles</button>
                            </div>
                        </div>

                        <div class="space-y-3 border-t pt-4 border-neutral">
                            <h4 class="font-poppins font-semibold text-dark">Price Range (₱):</h4>
                            
                            <div class="flex justify-between font-poppins text-sm">
                                <span class="text-dark/70">Min: <span id="desktop-min-price-display" class="price-range-display">₱20</span></span>
                                <span class="text-dark/70">Max: <span id="desktop-max-price-display" class="price-range-display">₱1000</span></span>
                            </div>

                            <div class="range-container">
                                <div class="range-slider-base"></div>
                                <div id="desktop-range-progress" class="range-progress"></div>
                                
                                <input id="desktop-min-price-range" type="range" min="20" max="1000" value="20" step="10" 
                                         oninput="updatePriceRange('desktop-')" class="range-input" style="z-index: 2;">
                                        
                                <input id="desktop-max-price-range" type="range" min="20" max="1000" value="1000" step="10" 
                                         oninput="updatePriceRange('desktop-')" class="range-input">
                            </div>
                        </div>

                        <button onclick="filterProducts(selectedCategory)" class="mt-6 w-full py-2 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft transform hover:scale-[1.02]">
                            APPLY PRICE FILTER
                        </button>
                    </div>
                </aside>

                <div class="w-full md:w-3/4 scrollable-grid">
                    <button onclick="toggleFilterModal()" class="md:hidden mb-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v7l-4 4v-7a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter & Price Range (Mobile)
                    </button>

                    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
                    <div id="pagination-controls" class="flex justify-center mt-8 pb-4"></div>
                </div>
            </div>
        </section>

        {{-- ==== MOBILE FILTER MODAL ==== --}}
        <div id="filter-modal" class="fixed inset-0 bg-dark bg-opacity-70 z-50 hidden transition-opacity duration-300">
            <div class="absolute bottom-0 w-full bg-neutral card-radius rounded-b-none p-6 transform translate-y-0 h-3/4 overflow-y-auto">
                <div class="flex justify-between items-center mb-6 border-b pb-4 border-gray-200">
                    <h2 class="text-2xl font-fredoka font-bold text-dark">Filter Products</h2>
                    <button onclick="toggleFilterModal()" class="text-dark hover:text-sakura transition-default p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div>
                        <h4 class="font-poppins font-semibold text-dark mb-2">Categories</h4>
                        <div class="flex flex-wrap gap-2">
                            <span onclick="selectCategory('all');" data-category="all" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default selected">All Products</span>
                            <span onclick="selectCategory('home-supplies');" data-category="home-supplies" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Home Supplies</span>
                            <span onclick="selectCategory('fashion-accessories');" data-category="fashion-accessories" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Fashion Accessories</span>
                            <span onclick="selectCategory('luggage-bags');" data-category="luggage-bags" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Luggage & Bags</span>
                            <span onclick="selectCategory('collectibles');" data-category="collectibles" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Collectibles</span>
                        </div>
                    </div>

                    <div class="space-y-3 border-t pt-4 border-neutral">
                        <h4 class="font-poppins font-semibold text-dark">Price Range (₱):</h4>

                        <div class="flex justify-between font-poppins text-sm">
                            <span class="text-dark/70">Min: <span id="mobile-min-price-display" class="price-range-display">₱20</span></span>
                            <span class="text-dark/70">Max: <span id="mobile-max-price-display" class="price-range-display">₱1000</span></span>
                        </div>

                        <div class="range-container">
                            <div class="range-slider-base"></div>
                            <div id="mobile-range-progress" class="range-progress"></div>

                            <input id="mobile-min-price-range" type="range" min="20" max="1000" value="20" step="10" 
                                oninput="updatePriceRange('mobile-')" class="range-input" style="z-index: 2;">
                                
                            <input id="mobile-max-price-range" type="range" min="20" max="1000" value="1000" step="10" 
                                oninput="updatePriceRange('mobile-')" class="range-input">
                        </div>
                    </div>
                </div>

                <button onclick="filterProducts(selectedCategory)" class="mt-8 w-full py-3 font-fredoka font-bold card-radius text-white bg-cta hover:bg-opacity-90 transition-default shadow-soft">
                    APPLY & VIEW RESULTS
                </button>
            </div>
        </div>

        {{-- ==== CART SUCCESS POPUP ==== --}}
        <div id="cart-success-modal" class="fixed bottom-4 left-0 right-0 z-50 transform translate-y-full transition-all duration-500 max-w-sm mx-auto opacity-0">
            <div class="bg-white p-4 card-radius shadow-sakura-outline flex items-center justify-between space-x-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-poppins font-semibold text-dark">Product Added to Cart!</span>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ url('/cart') }}" class="text-sm font-fredoka font-bold text-sakura underline hover:no-underline transition-default">View Cart</a>
                    <button onclick="hideCartSuccess()" class="p-1 rounded-full text-dark hover:bg-neutral transition-default">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <script src="{{ asset('catalog.js') }}"></script>
        <script>
            const PHP_PRODUCTS_DATA = @json($products);
            
            window.addEventListener('load', () => {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
                
                if (typeof initCatalog === 'function') {
                    initCatalog(PHP_PRODUCTS_DATA);
                }
            });
        </script>
    </main>
</x-layout>