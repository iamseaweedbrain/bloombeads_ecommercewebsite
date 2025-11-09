<x-layout>
    @php
        $categories_map = [
            'Fashion Accessories' => 'fashion-accessories',
            'Collectibles' => 'collectibles',
            'Home Supplies' => 'home-supplies',
            'Luggage & Bags' => 'luggage-bags',
        ];

        $js_products = [];

        foreach ($products as $product) {
            $js_products[] = [
                'id' => $product->id, 
                'imagePath' => 'storage/' . $product->image_path,
                'name' => $product->name,
                'category' => $product->category,
                'price' => (float) $product->price,
                'description' => $product->description,
                
                // vvv THIS IS THE NEW LINE vvv
                'stock' => (int) $product->stock,
                // ^^^ END OF NEW LINE ^^^

                'productCategoryTag' => $categories_map[$product->category] ?? 'all'
            ];
        }

        $isLoggedIn = Auth::check();
        $authUrl = route('auth.page');
    @endphp

    <main class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 pb-16" 
          data-cart-add-url="{{ $isLoggedIn ? route('cart.add') : '' }}">
        
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
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6-4.14 6.414a1 1 0 00-.293.707v7l-4 4v-7a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter & Price Range (Mobile)
                    </button>

                    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
                    <div id="pagination-controls" class="flex justify-center mt-8 pb-4"></div>
                </div>
            </div>
        </section>

        {{-- ==== MOBILE FILTER MODAL ==== --}}
        <div id="filter-modal" class="fixed inset-0 bg-dark bg-opacity-70 z-50 hidden transition-opacity duration-300">
            <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl shadow-lg p-6 transform translate-y-full transition-transform duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-fredoka font-bold">Product Filters</h3>
                    <button onclick="toggleFilterModal()" aria-label="Close filters">
                        <svg class="w-6 h-6 text-dark/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 mb-6">
                    <h4 class="font-poppins font-semibold text-dark">Filter By Category:</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <span onclick="selectCategory('all')" data-category="all" class="mobile-filter-span text-center px-3 py-2 text-sm card-radius font-poppins transition-default cursor-pointer">All</span>
                        <span onclick="selectCategory('home-supplies')" data-category="home-supplies" class="mobile-filter-span text-center px-3 py-2 text-sm card-radius font-poppins transition-default cursor-pointer">Home</span>
                        <span onclick="selectCategory('fashion-accessories')" data-category="fashion-accessories" class="mobile-filter-span text-center px-3 py-2 text-sm card-radius font-poppins transition-default cursor-pointer">Fashion</span>
                        <span onclick="selectCategory('luggage-bags')" data-category="luggage-bags" class="mobile-filter-span text-center px-3 py-2 text-sm card-radius font-poppins transition-default cursor-pointer">Bags</span>
                        <span onclick="selectCategory('collectibles')" data-category="collectibles" class="mobile-filter-span text-center px-3 py-2 text-sm card-radius font-poppins transition-default cursor-pointer">Collectibles</span>
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
                        <input id="mobile-min-price-range" type="range" min="20" max="1000" value="20" step="10" oninput="updatePriceRange('mobile-')" class="range-input" style="z-index: 2;">
                        <input id="mobile-max-price-range" type="range" min="20" max="1000" value="1000" step="10" oninput="updatePriceRange('mobile-')" class="range-input">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button onclick="filterProducts(selectedCategory)" class="w-full py-3 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft">
                        APPLY FILTERS
                    </button>
                    <button onclick="toggleFilterModal()" class="w-full py-3 font-fredoka font-bold card-radius text-dark bg-neutral hover:bg-gray-200 transition-default shadow-soft">
                        CLOSE
                    </button>
                </div>
            </div>
        </div>

        <!-- PRODUCT MODAL -->
        <div id="product-modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-soft max-w-md w-full p-6 relative">
                <h2 id="modal-product-name" class="text-xl font-fredoka text-dark mb-4"></h2>
                <img id="modal-product-image" src="" alt="Product Image" class="w-full h-48 object-cover rounded-lg mb-4 bg-gray-100">
                <p class="text-sakura font-bold text-lg mb-2" id="modal-product-price"></p>
                <p class="text-sm text-dark/70 mb-1">
                    <span class="font-semibold">Stock #:</span>
                    <span id="modal-product-stock">10001</span>
                </p>
                <p class="text-sm text-dark/70 mb-1">
                    <span class="font-semibold">Category:</span>
                    <span id="modal-product-category"></span>
                </p>
                <p class="text-sm text-dark mt-3" id="modal-product-description"></p>

                <button onclick="closeProductModal()" class="mt-6 w-full py-2 bg-sakura text-white font-poppins rounded-xl hover:bg-sakura/90">
                    Close
                </button>
            </div>
        </div>
        

        <script src="{{ asset('js/catalog.js') }}"></script>
        <script>
            const PHP_PRODUCTS_DATA = @json($js_products);
            
            window.addEventListener('load', () => {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
                
                if (typeof initCatalog === 'function') {
                    initCatalog(PHP_PRODUCTS_DATA, {{ $isLoggedIn ? 'true' : 'false' }}, '{{ $authUrl }}');
                }
            });
            function openProductModal(product) {
                document.getElementById("modal-product-name").textContent = product.name;
                document.getElementById("modal-product-price").textContent = `₱${product.price}`;
                document.getElementById("modal-product-image").src = product.image;
                document.getElementById("modal-product-stock").textContent = product.stock;
                document.getElementById("modal-product-category").textContent = product.category;
                document.getElementById("modal-product-description").textContent = product.description;

                document.getElementById("product-modal").classList.remove("hidden");
            }

            function closeProductModal() {
                document.getElementById("product-modal").classList.add("hidden");
            }

            document.addEventListener("click", function(e) {
                if (e.target.closest(".view-details-btn")) {
                    const btn = e.target.closest(".view-details-btn");

                    openProductModal({
                        name: btn.dataset.name,
                        price: btn.dataset.price,
                        image: btn.dataset.image,
                        stock: btn.dataset.stock,
                        category: btn.dataset.category,
                        description: btn.dataset.description
                    });
                }

                // Click outside modal to close
                if (e.target.id === "product-modal") closeProductModal();
            });
        </script>
    </main>
</x-layout>