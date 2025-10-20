@php
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
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloombeads - Browse Catalogue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400..700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('catalog.css') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sakura: '#FF6B81',
                        sky: '#48DBFB',
                        cta: '#FFB347',
                        dark: '#333333',
                        neutral: '#F7F7F7',
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
    {{-- Header Component --}}
    <x-header />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div id="shop-search-bar" class="py-6">
            <input type="text" placeholder="Search product name, category, or trend..."
                   class="w-full p-2 card-radius border border-gray-300 shadow-soft"
                   oninput="console.log('Searching...')">
        </div>

        <section id="shop-view" class="py-4 md:py-8">
            <h2 class="text-3xl font-fredoka font-bold mb-8">Browse Catalogue</h2>
            <p class="text-dark/80 font-poppins mb-6">Find pre-made designs and inspiration for your next custom piece.</p>

            <div class="flex flex-col md:flex-row gap-8 main-content-wrapper">
                
                {{-- Filter Component --}}
                <x-filterproducts />

                <div class="w-full md:w-3/4 scrollable-grid">
                    <button onclick="toggleFilterModal()" class="md:hidden mb-4 w-full py-3 font-fredoka font-bold card-radius text-white bg-sky hover:bg-opacity-80 transition-default shadow-soft">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v7l-4 4v-7a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter By Category (Mobile)
                    </button>

                    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
                    <div id="pagination-controls" class="flex justify-center mt-8 pb-4"></div>
                </div>
            </div>
        </section>

        {{-- Cart Success Modal --}}
        <div id="cart-success-modal" class="fixed bottom-4 left-0 right-0 z-50 transform translate-y-full transition-transform duration-500 max-w-sm mx-auto opacity-0">
            <div class="bg-white p-4 card-radius shadow-sakura-outline flex items-center justify-between space-x-3">
                <div class="flex items-center space-x-3">
                    <i data-lucide="check" class="w-6 h-6 text-dark"></i>
                    <span class="font-poppins font-semibold text-dark">Product Added to Cart!</span>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="/cart" class="text-sm font-fredoka font-bold text-sakura underline hover:no-underline transition-default">View Cart</a>
                    <button onclick="hideCartSuccess()" class="p-1 rounded-full text-dark hover:bg-neutral transition-default">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    {{-- Pass product data to JS --}}
    <script>
        const PHP_PRODUCTS_DATA = @json($products);
        window.onload = function() {
            lucide.createIcons();
            initCatalog(PHP_PRODUCTS_DATA);
        };
    </script>

    {{-- Custom JS --}}
    <script src="{{ asset('catalog.js') }}"></script>
</body>
</html>
