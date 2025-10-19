<?php
$products = [];
$categories = [
    ['name' => 'Fashion Accessories', 'tag' => 'fashion-accessories'],
    ['name' => 'Collectibles', 'tag' => 'collectibles'],
    ['name' => 'Home Supplies', 'tag' => 'home-supplies'],
    ['name' => 'Luggage & Bags', 'tag' => 'luggage-bags'],
];
$base_price_min = 22;
$base_price_max = 999;

for ($i = 1; $i <= 50; $i++) {
    $category_data = $categories[array_rand($categories)];
    $price = round(rand($base_price_min, $base_price_max) / 10) * 10;
    
    if ($i === 1) {
        $imagePath = 'catalog-assets/jjkBagcharm.jpeg'; 
        $name = 'JJK (JUJUTSU KAISEN) BAGCHARMS';
        $category = 'Luggage & Bags';
        $price = 180.00;
        $productCategoryTag = 'luggage-bags';
    } else {
        $imagePath = "https://placehold.co/400x400/96b8d4/FFFFFF?text=Product+{$i}";
        $name = ($i % 5 === 0) ? "Deluxe Charm Item {$i}" : "Bead Style {$i}";
        $category = $category_data['name'];
        $price = $price;
        $productCategoryTag = $category_data['tag'];
    }

    $products[] = [
        'imagePath' => $imagePath, 
        'name' => $name, 
        'category' => $category, 
        'price' => $price, 
        'productCategoryTag' => $productCategoryTag
    ];
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloombeads - Browse Catalogue</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="catalog.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sakura: '#FF6B81', sky: '#48DBFB', cta: '#FFB347', dark: '#333333', neutral: '#F7F7F7',
                    },
                    fontFamily: {
                        fredoka: ['Fredoka', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>

<body class="min-h-screen bg-neutral">
    
    <script src="catalog.js"></script>
    <script>
        const PHP_PRODUCTS_DATA = <?php echo json_encode($products); ?>;

        window.onload = function() {
            initCatalog(PHP_PRODUCTS_DATA);
        };
    </script>
    
    <header class="bg-white shadow-soft sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex-shrink-0">
                    <a href="homepage.php" class="text-2xl font-fredoka font-bold text-sakura hover:text-dark transition-default">Bloombeads</a>
                </div>

                <nav class="hidden md:flex space-x-8">
                    <?php $currentPage = basename($_SERVER['PHP_SELF']);?>
                    
                    <a href="homepage.php" class="nav-link text-dark hover:text-sakura transition-default font-poppins <?php echo ($currentPage == 'homepage.php' || !isset($_SERVER['PHP_SELF'])) ? '' : ''; ?>">Home</a>
                    <a href="catalog.php" class="nav-link text-dark hover:text-sakura transition-default font-poppins <?php echo ($currentPage == 'catalog.php' || !isset($_SERVER['PHP_SELF'])) ? 'nav-active' : ''; ?>">Browse Catalogue</a>
                    <a href="customize.php" class="nav-link text-dark hover:text-sakura transition-default font-poppins <?php echo ($currentPage == 'customize.php') ? 'nav-active' : ''; ?>">Design Yours</a>
                    <a href="support.php" class="nav-link text-dark hover:text-sakura transition-default font-poppins <?php echo ($currentPage == 'support.php') ? 'nav-active' : ''; ?>">Help & FAQs</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="settings.php" class="text-dark hover:text-sakura p-2 rounded-full hover:bg-neutral transition-default" title="Settings">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/>
                        <circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <a href="cart.php" class="text-dark hover:text-sakura p-2 rounded-full hover:bg-neutral transition-default" title="View Cart">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </a>
                    <a href="dashboard.php" class="text-dark hover:text-sakura p-2 rounded-full hover:bg-neutral transition-default" title="User Account/Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-icon lucide-user-round">

                        <circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>     
                    </a>
                    <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden');" class="md:hidden text-dark hover:text-sakura p-2 rounded-full hover:bg-neutral transition-default">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="catalog.php" class="block w-full text-left px-3 py-2 rounded-lg text-base font-poppins text-dark hover:bg-neutral hover:text-sakura font-bold">Browse Catalogue</a>
                <a href="customize.php" class="block w-full text-left px-3 py-2 rounded-lg text-base font-poppins text-dark hover:bg-neutral hover:text-sakura">Design Yours</a>
                <a href="support.php" class="block w-full text-left px-3 py-2 rounded-lg text-base font-poppins text-dark hover:bg-neutral hover:text-sakura">Help & FAQs</a>
                <a href="settings.php" class="block w-full text-left px-3 py-2 rounded-lg text-base font-poppins text-dark hover:bg-neutral hover:text-sakura">Settings</a>
                <a href="dashboard.php" class="block w-full text-left px-3 py-2 rounded-lg text-base font-poppins text-dark hover:bg-neutral hover:text-sakura">Account / Sign In</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div id="shop-search-bar" class="py-6">
             <input type="text" placeholder="Search product name, category, or trend..." class="w-full p-2 card-radius border border-gray-300 shadow-soft" oninput="console.log('Searching...')">
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
                                <button onclick="selectCategory('all'); filterProducts('all');" data-category="all" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins hover:bg-gray-100 transition-default selected">All Products</button>
                                <button onclick="selectCategory('home-supplies'); filterProducts('home-supplies');" data-category="home-supplies" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins hover:bg-gray-100 transition-default">Home Supplies</button>
                                <button onclick="selectCategory('fashion-accessories'); filterProducts('fashion-accessories');" data-category="fashion-accessories" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins hover:bg-gray-100 transition-default">Fashion Accessories</button>
                                <button onclick="selectCategory('luggage-bags'); filterProducts('luggage-bags');" data-category="luggage-bags" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins hover:bg-gray-100 transition-default">Luggage & Bags</button>
                                <button onclick="selectCategory('collectibles'); filterProducts('collectibles');" data-category="collectibles" class="desktop-filter-btn filter-btn w-full text-left px-3 py-2 text-base card-radius font-poppins hover:bg-gray-100 transition-default">Collectibles</button>
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
                            VIEW FILTERED
                        </button>
                    </div>
                </aside>

                <div class="w-full md:w-3/4 scrollable-grid">
                    <button onclick="toggleFilterModal()" class="md:hidden mb-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v7l-4 4v-7a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter By Category (Mobile)
                    </button>

                    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        </div>
                    
                    <div id="pagination-controls" class="flex justify-center mt-8 pb-4">
                        </div>
                </div>
            </div>
        </section>

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
                            <span onclick="selectCategory('all'); filterProducts('all');" data-category="all" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">All Products</span>
                            <span onclick="selectCategory('home-supplies'); filterProducts('home-supplies');" data-category="home-supplies" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Home Supplies</span>
                            <span onclick="selectCategory('fashion-accessories'); filterProducts('fashion-accessories');" data-category="fashion-accessories" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Fashion Accessories</span>
                            <span onclick="selectCategory('luggage-bags'); filterProducts('luggage-bags');" data-category="luggage-bags" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Luggage & Bags</span>
                            <span onclick="selectCategory('collectibles'); filterProducts('collectibles');" data-category="collectibles" class="mobile-filter-span px-4 py-2 bg-white text-dark font-fredoka font-bold text-base card-radius shadow-soft cursor-pointer transition-default">Collectibles</span>
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
        
        <div id="cart-success-modal" class="fixed bottom-4 left-0 right-0 z-50 transform translate-y-full transition-transform duration-500 max-w-sm mx-auto opacity-0">
            <div class="bg-white p-4 card-radius shadow-sakura-outline flex items-center justify-between space-x-3">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-poppins font-semibold text-dark">Product Added to Cart!</span>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="cart.php" class="text-sm font-fredoka font-bold text-sakura underline hover:no-underline transition-default">View Cart</a>
                    <button onclick="hideCartSuccess()" class="p-1 rounded-full text-dark hover:bg-neutral transition-default">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>