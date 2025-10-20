<aside class="md:w-1/4 hidden md:block sticky-filter">
    <div class="bg-white p-6 card-radius shadow-soft sticky top-0">
        <h3 class="text-xl font-fredoka font-bold mb-4 border-b pb-2 border-neutral">Product Filters</h3>

        <div class="space-y-3 mb-6">
            <h4 class="font-poppins font-semibold text-dark">Filter By Category:</h4>
            <div class="flex flex-col gap-2">
                <button onclick="selectCategory('all'); filterProducts('all');" class="filter-btn">All Products</button>
                <button onclick="selectCategory('home-supplies'); filterProducts('home-supplies');" class="filter-btn">Home Supplies</button>
                <button onclick="selectCategory('fashion-accessories'); filterProducts('fashion-accessories');" class="filter-btn">Fashion Accessories</button>
                <button onclick="selectCategory('luggage-bags'); filterProducts('luggage-bags');" class="filter-btn">Luggage & Bags</button>
                <button onclick="selectCategory('collectibles'); filterProducts('collectibles');" class="filter-btn">Collectibles</button>
            </div>
        </div>

        <div class="space-y-3 border-t pt-4 border-neutral">
            <h4 class="font-poppins font-semibold text-dark">Price Range (₱):</h4>
            <div class="flex justify-between font-poppins text-sm">
                <span>Min: <span id="desktop-min-price-display">₱20</span></span>
                <span>Max: <span id="desktop-max-price-display">₱1000</span></span>
            </div>

            <div class="range-container">
                <div id="desktop-range-progress" class="range-progress"></div>
                <input id="desktop-min-price-range" type="range" min="20" max="1000" value="20" step="10" oninput="updatePriceRange('desktop-')" class="range-input">
                <input id="desktop-max-price-range" type="range" min="20" max="1000" value="1000" step="10" oninput="updatePriceRange('desktop-')" class="range-input">
            </div>
        </div>

        <button onclick="filterProducts(selectedCategory)" class="mt-6 w-full py-2 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft transform hover:scale-[1.02]">
            VIEW FILTERED
        </button>
    </div>
</aside>
