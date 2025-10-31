let ALL_PRODUCTS = []; 
const PRODUCTS_PER_PAGE = 16; 
let selectedCategory = 'all'; 
let cartSuccessTimeout; 
let globalMinPrice = 20; 
let globalMaxPrice = 1000;
let currentPage = 1;

function updatePriceRange(idPrefix) {
    const minInput = document.getElementById(idPrefix + 'min-price-range');
    const maxInput = document.getElementById(idPrefix + 'max-price-range');
    const progress = document.getElementById(idPrefix + 'range-progress');
    
    // Ensure elements exist before proceeding
    if (!minInput || !maxInput || !progress) return;

    let minVal = parseInt(minInput.value);
    let maxVal = parseInt(maxInput.value);
    
    if (minVal > maxVal) {
        minInput.value = maxVal;
        minVal = maxVal;
    }
    if (maxVal < minVal) {
        maxInput.value = minVal;
        maxVal = minVal;
    }

    // Synchronize the other slider's value display
    const otherPrefix = idPrefix === 'desktop-' ? 'mobile-' : 'desktop-';
    const otherMinInput = document.getElementById(otherPrefix + 'min-price-range');
    const otherMaxInput = document.getElementById(otherPrefix + 'max-price-range');
    const otherMinDisplay = document.getElementById(otherPrefix + 'min-price-display');
    const otherMaxDisplay = document.getElementById(otherPrefix + 'max-price-display');

    if (otherMinInput) otherMinInput.value = minVal;
    if (otherMaxInput) otherMaxInput.value = maxVal;
    if (otherMinDisplay) otherMinDisplay.textContent = '₱' + minVal;
    if (otherMaxDisplay) otherMaxDisplay.textContent = '₱' + maxVal;


    globalMinPrice = minVal;
    globalMaxPrice = maxVal;
    
    document.getElementById(idPrefix + 'min-price-display').textContent = '₱' + minVal;
    document.getElementById(idPrefix + 'max-price-display').textContent = '₱' + maxVal;
    
    const rangeMax = parseInt(minInput.max);
    const rangeMin = parseInt(minInput.min);
    const rangeDiff = rangeMax - rangeMin;

    const minPercent = ((minVal - rangeMin) / rangeDiff) * 100;
    const maxPercent = ((maxVal - rangeMin) / rangeDiff) * 100;
    
    progress.style.left = minPercent + '%';
    progress.style.width = (maxPercent - minPercent) + '%';
}

function filterProducts(category) {
    // If coming from a category button click, update the global category
    if (category) selectedCategory = category;

    // Reset to page 1 for a new filter query
    currentPage = 1;

    const searchInput = document.getElementById('shop-search-bar').querySelector('input');
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
    
    const filteredProducts = ALL_PRODUCTS.filter(product => {
        const categoryMatch = (selectedCategory === 'all' || product.productCategoryTag === selectedCategory);
        const priceMatch = (product.price >= globalMinPrice && product.price <= globalMaxPrice);
        const searchMatch = product.name.toLowerCase().includes(searchTerm) || 
                            product.category.toLowerCase().includes(searchTerm);
        
        return categoryMatch && priceMatch && searchMatch;
    });

    updateFilterButtons(selectedCategory);
    paginateProducts(filteredProducts);
    
    const modal = document.getElementById('filter-modal');
    // If the filter button was pressed inside the mobile modal, close it
    if (modal && !modal.classList.contains('hidden')) {
        toggleFilterModal();
    }
}

function paginateProducts(products) {
    const totalPages = Math.ceil(products.length / PRODUCTS_PER_PAGE);
    const startIndex = (currentPage - 1) * PRODUCTS_PER_PAGE;
    const endIndex = startIndex + PRODUCTS_PER_PAGE;
    const productsOnPage = products.slice(startIndex, endIndex);

    renderProductGrid(productsOnPage);
    renderPagination(totalPages);
}

function renderProductGrid(products) {
    const grid = document.getElementById('product-grid');
    let html = '';
    
    if (!grid) return;

    if (products.length === 0) {
        grid.innerHTML = '<div class="col-span-full text-center py-12 text-xl font-poppins text-dark/70">😔 No products found matching your filter criteria.</div>';
        return;
    }

    products.forEach(product => {
        html += `
            <div class="product-card bg-white card-radius shadow-soft overflow-hidden transition-default group hover:shadow-lg" 
                data-category="${product.productCategoryTag}"
                data-price="${product.price}">
                <div class="aspect-square bg-gray-200 flex items-center justify-center">
                    <img src="${product.imagePath}" alt="${product.name}" class="w-full h-full object-cover">
                </div>
                <div class="p-3">
                    <h4 class="font-poppins font-semibold text-dark truncate group-hover:text-sky">${product.name}</h4>
                    <p class="font-poppins font-bold text-xs text-dark/70">${product.category}</p>
                    <p class="font-poppins font-bold text-xl text-sakura my-1">₱${product.price.toFixed(2)}</p>
                    <div class="flex justify-between items-center mt-2">
                        <a href="#" class="text-sm text-dark hover:text-sky transition-default font-poppins">View Details</a>
                        <button onclick="showCartSuccess()" class="p-2 rounded-full bg-cta text-white hover:bg-opacity-90 transition-default transform group-hover:scale-110">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    grid.innerHTML = html;
}

function renderPagination(totalPages) {
    const paginationContainer = document.getElementById('pagination-controls');
    if (!paginationContainer) return;
    
    let html = '<div class="flex space-x-2">';
    for (let i = 1; i <= totalPages; i++) {
        
        let isActiveClasses = 'bg-white text-dark hover:bg-neutral';
        
        if (i === currentPage) {
            isActiveClasses = 'bg-sakura text-white font-bold shadow-md'; 
        }
        
        html += `<button onclick="changePage(${i})" class="px-3 py-1 font-fredoka card-radius ${isActiveClasses} shadow-soft transition-default">${i}</button>`;
    }
    html += '</div>';
    paginationContainer.innerHTML = html;
}

function changePage(pageNumber) {
    if (pageNumber === currentPage) return; 
    
    currentPage = pageNumber;
    
    // Re-run filterProducts without changing the current filters
    const searchInput = document.getElementById('shop-search-bar').querySelector('input');
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
    
    const filteredProducts = ALL_PRODUCTS.filter(product => {
        const categoryMatch = (selectedCategory === 'all' || product.productCategoryTag === selectedCategory);
        const priceMatch = (product.price >= globalMinPrice && product.price <= globalMaxPrice);
        const searchMatch = product.name.toLowerCase().includes(searchTerm) || 
                            product.category.toLowerCase().includes(searchTerm);
        
        return categoryMatch && priceMatch && searchMatch;
    });

    paginateProducts(filteredProducts); 
    
    const scrollableGrid = document.querySelector('.scrollable-grid');
    if(scrollableGrid) scrollableGrid.scrollTop = 0;
}


function selectCategory(category) {
    selectedCategory = category;
    updateFilterButtons(category);
}

function updateFilterButtons(category) {
    document.querySelectorAll('.desktop-filter-btn, .mobile-filter-span').forEach(el => {
        const isSelected = el.dataset.category === category;
        el.classList.toggle('selected', isSelected);
        el.classList.toggle('bg-white', !isSelected);
        el.classList.toggle('text-dark', !isSelected);
        el.classList.toggle('bg-sakura', isSelected);
        el.classList.toggle('text-white', isSelected);
    });
}

function toggleFilterModal() {
    const modal = document.getElementById('filter-modal');
    modal.classList.toggle('hidden');
    document.body.classList.toggle('overflow-hidden');
    if (!modal.classList.contains('hidden')) { 
        updatePriceRange('mobile-');
        updateFilterButtons(selectedCategory); 
    }
}

function showCartSuccess() {
    const modal = document.getElementById('cart-success-modal');
    clearTimeout(cartSuccessTimeout);
    modal.classList.remove('translate-y-full', 'opacity-0');
    modal.classList.add('translate-y-0', 'opacity-100');

    cartSuccessTimeout = setTimeout(() => { hideCartSuccess(); }, 3000); 
}

function hideCartSuccess() {
    const modal = document.getElementById('cart-success-modal');
    modal.classList.remove('translate-y-0', 'opacity-100');
    modal.classList.add('translate-y-full', 'opacity-0');
    clearTimeout(cartSuccessTimeout); 
}

function initCatalog(products) {
    ALL_PRODUCTS = products;
    
    globalMinPrice = 20;
    globalMaxPrice = 1000;
    currentPage = 1;
    selectedCategory = 'all'; 
    
    updatePriceRange('desktop-');
    updatePriceRange('mobile-');

    const modal = document.getElementById('cart-success-modal');
    if(modal) modal.classList.add('translate-y-full', 'opacity-0'); 

    filterProducts('all'); 
}