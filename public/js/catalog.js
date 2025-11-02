// --- Global variables ---
let ALL_PRODUCTS = [];
const PRODUCTS_PER_PAGE = 16;
let selectedCategory = 'all';
let cartSuccessTimeout;
let globalMinPrice = 20;
let globalMaxPrice = 1000;
let currentPage = 1;
let csrfToken = ''; 
let cartAddUrl = ''; 
let IS_LOGGED_IN = false; // <-- ADD THIS
let AUTH_URL = '/auth'; // <-- ADD THIS

// --- DOM Element Cache ---
let desktopMinRange, desktopMaxRange, desktopMinDisplay, desktopMaxDisplay, desktopProgress;
let mobileMinRange, mobileMaxRange, mobileMinDisplay, mobileMaxDisplay, mobileProgress;
let productGrid, paginationContainer, searchInput, filterModal;

/**
 * Caches frequently accessed DOM elements.
 */
function cacheDOMElements() {
    desktopMinRange = document.getElementById('desktop-min-price-range');
    desktopMaxRange = document.getElementById('desktop-max-price-range');
    desktopMinDisplay = document.getElementById('desktop-min-price-display');
    desktopMaxDisplay = document.getElementById('desktop-max-price-display');
    desktopProgress = document.getElementById('desktop-range-progress');
    
    mobileMinRange = document.getElementById('mobile-min-price-range');
    mobileMaxRange = document.getElementById('mobile-max-price-range');
    mobileMinDisplay = document.getElementById('mobile-min-price-display');
    mobileMaxDisplay = document.getElementById('mobile-max-price-display');
    mobileProgress = document.getElementById('mobile-range-progress');

    productGrid = document.getElementById('product-grid');
    paginationContainer = document.getElementById('pagination-controls');
    searchInput = document.getElementById('shop-search-bar')?.querySelector('input');
    filterModal = document.getElementById('filter-modal');
}

/**
 * Updates the price range sliders and displays.
 * @param {string} prefix - 'desktop-' or 'mobile-'
 */
function updatePriceRange(prefix) {
    const minInput = prefix === 'desktop-' ? desktopMinRange : mobileMinRange;
    const maxInput = prefix === 'desktop-' ? desktopMaxRange : mobileMaxRange;
    const minDisplay = prefix ==='desktop-' ? desktopMinDisplay : mobileMinDisplay;
    const maxDisplay = prefix === 'desktop-' ? desktopMaxDisplay : mobileMaxDisplay;
    const progress = prefix ==='desktop-' ? desktopProgress : mobileProgress;
    
    if (!minInput || !maxInput || !minDisplay || !maxDisplay || !progress) return;

    let minVal = parseInt(minInput.value);
    let maxVal = parseInt(maxInput.value);
    const step = parseInt(minInput.step) || 1;

    if (minVal >= maxVal) {
        const movedSlider = event?.target;
        if (movedSlider === minInput) minVal = maxVal - step;
        else maxVal = minVal + step;
        minVal = Math.max(parseInt(minInput.min), Math.min(minVal, parseInt(minInput.max) - step));
        maxVal = Math.min(parseInt(maxInput.max), Math.max(maxVal, parseInt(maxInput.min) + step));
        minInput.value = minVal;
        maxInput.value = maxVal;
    }

    globalMinPrice = minVal;
    globalMaxPrice = maxVal;
    minDisplay.textContent = `₱${minVal}`;
    maxDisplay.textContent = `₱${maxVal}`;

    const rangeMax = parseInt(minInput.max);
    const rangeMin = parseInt(minInput.min);
    const rangeDiff = rangeMax - rangeMin;
    if (rangeDiff > 0) {
        const minPercent = Math.max(0, Math.min(100, ((minVal - rangeMin) / rangeDiff) * 100));
        const maxPercent = Math.max(0, Math.min(100, ((maxVal - rangeMin) / rangeDiff) * 100));
        progress.style.left = `${minPercent}%`;
        progress.style.width = `${maxPercent - minPercent}%`;
    }

    // Sync the other slider
    const otherPrefix = prefix === 'desktop-' ? 'mobile-' : 'desktop-';
    const otherMinInput = document.getElementById(otherPrefix + 'min-price-range');
    const otherMaxInput = document.getElementById(otherPrefix + 'max-price-range');
    const otherMinDisplay = document.getElementById(otherPrefix + 'min-price-display');
    const otherMaxDisplay = document.getElementById(otherPrefix + 'max-price-display');
    const otherProgress = document.getElementById(otherPrefix + 'range-progress');
    
    if (otherMinInput) otherMinInput.value = minVal;
    if (otherMaxInput) otherMaxInput.value = maxVal;
    if (otherMinDisplay) otherMinDisplay.textContent = `₱${minVal}`;
    if (otherMaxDisplay) otherMaxDisplay.textContent = `₱${maxVal}`;
    if (otherProgress && rangeDiff > 0) {
        const minPercent = Math.max(0, Math.min(100, ((minVal - rangeMin) / rangeDiff) * 100));
        const maxPercent = Math.max(0, Math.min(100, ((maxVal - rangeMin) / rangeDiff) * 100));
        otherProgress.style.left = `${minPercent}%`;
        otherProgress.style.width = `${maxPercent - minPercent}%`;
    }
}
window.updatePriceRange = updatePriceRange;

/**
 * Filters products based on global state (category, price, search) and triggers pagination.
 * @param {string|null} category - Optional category to set before filtering.
 */
function filterProducts(category = null) {
    if (category) {
        selectedCategory = category;
        updateFilterButtons(selectedCategory);
    }
    currentPage = 1; 
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

    const filtered = ALL_PRODUCTS.filter(product => {
        const categoryMatch = (selectedCategory === 'all' || product.productCategoryTag === selectedCategory);
        const priceMatch = (product.price >= globalMinPrice && product.price <= globalMaxPrice);
        const searchMatch = !searchTerm ||
                            (product.name.toLowerCase().includes(searchTerm) ||
                             product.category.toLowerCase().includes(searchTerm));
        return categoryMatch && priceMatch && searchMatch;
    });

    paginateProducts(filtered);

    if (filterModal && !filterModal.classList.contains('hidden') && event && event.target.closest('#filter-modal button:not([onclick*="toggleFilterModal"])')) {
        toggleFilterModal();
    }
}
window.filterProducts = filterProducts;

/**
 * Paginates a list of products.
 * @param {Array} products - The filtered list of products.
 */
function paginateProducts(products) {
    const totalItems = products.length;
    const totalPages = Math.max(1, Math.ceil(totalItems / PRODUCTS_PER_PAGE));
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;
    const startIndex = (currentPage - 1) * PRODUCTS_PER_PAGE;
    const productsOnPage = products.slice(startIndex, startIndex + PRODUCTS_PER_PAGE);
    renderProductGrid(productsOnPage);
    renderPagination(totalPages, totalItems);
}

/**
 * Renders the product cards into the grid.
 * @param {Array} products - The products to display for the current page.
 */
function renderProductGrid(products) {
    if (!productGrid) return; 
    if (products.length === 0) {
        productGrid.innerHTML = '<div class="col-span-full text-center py-12 text-lg font-poppins text-dark/70">😔 No products match your criteria.</div>';
        return;
    }
    
    productGrid.innerHTML = products.map(product => `
        <div class_name="product-card bg-white card-radius shadow-soft overflow-hidden transition-shadow duration-300 group hover:shadow-lg flex flex-col"
             data-category="${product.productCategoryTag}" data-price="${product.price}">
            <a href="#" class="block aspect-square bg-gray-100 items-center justify-center overflow-hidden group/image" aria-label="View details for ${product.name}">
                <img src="${product.imagePath}" alt="" class="w-full h-full object-cover transition-transform duration-300 group-hover/image:scale-105" loading="lazy">
            </a>
            <div class="p-3 flex flex-col grow">
                <h4 class="font-poppins font-semibold text-dark truncate group-hover:text-sky mb-1 text-sm sm:text-base" title="${product.name}">${product.name}</h4>
                <p class="font-poppins text-xs text-dark/70 mb-1 capitalize">${product.productCategoryTag.replace('-', ' ')}</p>
                <p class="font-poppins font-bold text-lg sm:text-xl text-sakura my-1">₱${product.price.toFixed(2)}</p>
                <div class="mt-auto pt-2 flex justify-between items-center">
                     <a href="#" class="text-xs sm:text-sm text-dark hover:text-sky transition-default font-poppins">View Details</a>
                     <form action="${cartAddUrl}" method="POST" class="add-to-cart-form">
                         <input type="hidden" name="_token" value="${csrfToken}">
                         <input type="hidden" name="product_id" value="${product.id}">
                         <input type="hidden" name="quantity" value="1">
                         <button type="submit" class="p-2 rounded-full bg-cta text-white hover:bg-opacity-90 transition-all duration-200 transform group-hover:scale-110 focus:outline-none focus:ring-2 focus:ring-cta focus:ring-offset-1" aria-label="Add ${product.name} to cart">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                         </button>
                     </form>
                </div>
            </div>
        </div>
    `).join('');
    
    addCartFormListeners(); 
}

/**
 * Attaches submit event listeners to all add-to-cart forms using delegation.
 */
function addCartFormListeners() {
    if (!productGrid) return;
    productGrid.removeEventListener('submit', handleCartFormSubmitDelegation); 
    productGrid.addEventListener('submit', handleCartFormSubmitDelegation);
}

/**
 * Handles the submit event delegated from the product grid.
 */
function handleCartFormSubmitDelegation(event) {
    if (event.target.matches('.add-to-cart-form')) {
        event.preventDefault(); 
        handleCartFormSubmit(event.target); 
    }
}

/**
 * Handles the form submission using Fetch API.
 * @param {HTMLFormElement} form - The form that was submitted.
 */
function handleCartFormSubmit(form) {
    // vvv NEW CHECK vvv
    if (!IS_LOGGED_IN) {
        // If user is not logged in, show a toast and redirect
        if (typeof showToast === 'function') {
            showToast('Please log in to add items to your cart.', 'error');
        }
        setTimeout(() => {
            window.location.href = AUTH_URL;
        }, 2000);
        return; // Stop the function
    }
    // ^^^ END OF NEW CHECK ^^^

    const formData = new FormData(form);
    const button = form.querySelector('button[type="submit"]');
    if (button) button.disabled = true;

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => response.json().then(data => ({ ok: response.ok, data })))
    .then(({ ok, data }) => {
        if (ok && data.success) {
            if (typeof showToast === 'function') {
                showToast(data.message || 'Product added!', 'success');
            }
            if (typeof updateCartBadge === 'function') {
                updateCartBadge(data.totalQuantity);
            }
        } else {
            if (typeof showToast === 'function') {
                showToast(data.error || data.message || 'Failed to add product.', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Add to cart fetch error:', error);
        if (typeof showToast === 'function') {
            showToast('Error adding item. Please try again.', 'error');
        }
    })
    .finally(() => {
         if (button) button.disabled = false;
    });
}

/**
 * Renders pagination controls.
 * @param {number} totalPages - Total number of pages.
 * @param {number} totalItems - Total number of filtered items.
 */
function renderPagination(totalPages, totalItems) {
    if (!paginationContainer) return;
    if (totalItems === 0 || totalPages <= 1) {
        paginationContainer.innerHTML = ''; 
        return;
    }
    
    let html = '<nav aria-label="Product pagination"><ul class="flex flex-wrap justify-center items-center gap-1 sm:gap-2">';
    html += `<li>${currentPage > 1 ? `<button onclick="changePage(${currentPage - 1})" aria-label="Previous page" class="pagination-btn">&laquo; Prev</button>` : `<span class="pagination-disabled">&laquo; Prev</span>`}</li>`;

    const maxPagesToShow = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
    let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
    if (endPage === totalPages && totalPages >= maxPagesToShow) startPage = Math.max(1, totalPages - maxPagesToShow + 1);
    if (startPage === 1 && totalPages >= maxPagesToShow) endPage = Math.min(totalPages, maxPagesToShow);

    if (startPage > 1) {
        html += `<li><button onclick="changePage(1)" aria-label="Go to page 1" class="pagination-btn">1</button></li>`;
        if (startPage > 2) html += `<li class="pagination-ellipsis" aria-hidden="true">...</li>`;
    }
    for (let i = startPage; i <= endPage; i++) {
        const isCurrent = i === currentPage;
        html += `<li><button onclick="changePage(${i})" aria-label="Go to page ${i}" ${isCurrent ? 'aria-current="page"' : ''} class="pagination-btn ${isCurrent ? 'active' : ''}">${i}</button></li>`;
    }
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) html += `<li class="pagination-ellipsis" aria-hidden="true">...</li>`;
        html += `<li><button onclick="changePage(${totalPages})" aria-label="Go to last page (${totalPages})" class="pagination-btn">${totalPages}</button></li>`;
    }
    html += `<li>${currentPage < totalPages ? `<button onclick="changePage(${currentPage + 1})" aria-label="Next page" class="pagination-btn">Next &raquo;</button>` : `<span class="pagination-disabled">Next &raquo;</span>`}</li>`;
    html += '</ul></nav>';
    paginationContainer.innerHTML = html;

     paginationContainer.querySelectorAll('button, span').forEach(el => {
         el.classList.add('px-2', 'py-1', 'sm:px-3', 'sm:py-1', 'mb-1', 'font-fredoka', 'card-radius', 'shadow-soft', 'transition-default');
         if(el.tagName === 'BUTTON' && !el.classList.contains('active')) el.classList.add('bg-white', 'text-dark', 'hover:bg-neutral');
         if(el.classList.contains('active')) el.classList.add('bg-sakura', 'text-white', 'font-bold', 'cursor-default', 'ring-2', 'ring-offset-1', 'ring-sakura');
         if(el.tagName === 'SPAN' && !el.classList.contains('pagination-ellipsis')) el.classList.add('bg-gray-200', 'text-gray-400', 'cursor-not-allowed', 'shadow-inner');
         if(el.classList.contains('pagination-ellipsis')) el.classList.add('text-gray-500', 'shadow-none', 'bg-transparent');
     });
}

/**
 * Changes the current page and re-filters/renders products.
 * @param {number} pageNumber - The page to navigate to.
 */
function changePage(pageNumber) {
    if (pageNumber === currentPage || pageNumber < 1) return;
    currentPage = pageNumber;
    filterProducts(); 
    const shopView = document.getElementById('shop-view');
    if (shopView) {
        const headerHeight = document.querySelector('header')?.offsetHeight || 64;
        const elementPosition = shopView.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({ top: elementPosition - headerHeight - 20, behavior: 'smooth' });
    }
}
window.changePage = changePage; 

// --- Filter Button/Modal Logic ---
function selectCategory(category) {
    if (selectedCategory !== category) {
        selectedCategory = category;
        updateFilterButtons(category);
    }
}
window.selectCategory = selectCategory; 

function updateFilterButtons(category) {
    document.querySelectorAll('.desktop-filter-btn, .mobile-filter-span').forEach(el => {
        const isSelected = el.dataset.category === category;
        el.classList.toggle('selected', isSelected);
        el.classList.toggle('bg-sakura', isSelected);
        el.classList.toggle('text-white', isSelected);
        el.classList.toggle('font-bold', isSelected);
        el.classList.toggle('bg-white', !isSelected);
        el.classList.toggle('text-dark', !isSelected);
    });
}

function toggleFilterModal() {
    if (!filterModal) return;
    const currentlyHidden = filterModal.classList.contains('hidden');
    const innerContent = filterModal.querySelector('div:first-child');
    const toggleButton = document.querySelector('button[onclick*="toggleFilterModal"]');

    if (currentlyHidden) {
        updatePriceRange('mobile-'); 
        updateFilterButtons(selectedCategory); 
        filterModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if(toggleButton) toggleButton.setAttribute('aria-expanded', 'true');
        requestAnimationFrame(() => {
            filterModal.classList.remove('opacity-0');
            if (innerContent) innerContent.classList.remove('translate-y-full');
        });
    } else {
        filterModal.classList.add('opacity-0');
        if (innerContent) innerContent.classList.add('translate-y-full');
        if(toggleButton) toggleButton.setAttribute('aria-expanded', 'false');
        setTimeout(() => {
            filterModal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300); 
    }
}
window.toggleFilterModal = toggleFilterModal; 


// --- Initialization ---
/**
 * @param {Array} products -
 * @param {boolean} isLoggedIn -
 * @param {string} authUrl -
 */
function initCatalog(products, isLoggedIn, authUrl) {
    ALL_PRODUCTS = Array.isArray(products) ? products : [];
    IS_LOGGED_IN = isLoggedIn;
    AUTH_URL = authUrl;
    
    cacheDOMElements(); 

    csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    const mainElement = document.querySelector('main[data-cart-add-url]');
    if (mainElement) {
        cartAddUrl = mainElement.dataset.cartAddUrl || '';
    }

    if (!csrfToken) console.error('CSRF token meta tag not found!');

    if (desktopMinRange && desktopMaxRange) {
        globalMinPrice = parseInt(desktopMinRange.value);
        globalMaxPrice = parseInt(desktopMaxRange.value);
    } else if (mobileMinRange && mobileMaxRange) {
        globalMinPrice = parseInt(mobileMinRange.value);
        globalMaxPrice = parseInt(mobileMaxRange.value);
    } 

    currentPage = 1;
    selectedCategory = 'all';

    updatePriceRange('desktop-');
    updatePriceRange('mobile-');
    updateFilterButtons(selectedCategory);

    filterProducts(selectedCategory); 
}
window.initCatalog = initCatalog; 

// --- General Event Listeners ---
document.addEventListener('DOMContentLoaded', () => {
    cacheDOMElements(); 

     if(desktopMinRange && desktopMaxRange) {
         desktopMinRange.addEventListener('input', () => updatePriceRange('desktop-'));
         desktopMaxRange.addEventListener('input', () => updatePriceRange('desktop-'));
     }
     if(mobileMinRange && mobileMaxRange) {
          mobileMinRange.addEventListener('input', () => updatePriceRange('mobile-'));
          mobileMaxRange.addEventListener('input', () => updatePriceRange('mobile-'));
     }
     if(desktopMinRange) desktopMinRange.addEventListener('change', () => filterProducts());
     if(desktopMaxRange) desktopMaxRange.addEventListener('change', () => filterProducts());
     if(mobileMinRange) mobileMinRange.addEventListener('change', () => filterProducts());
     if(mobileMaxRange) mobileMaxRange.addEventListener('change', () => filterProducts());
});