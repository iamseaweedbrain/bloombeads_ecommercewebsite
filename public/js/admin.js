let salesChartInstance;
let productChartInstance;
const productModal = document.getElementById('productModal');
const productForm = document.getElementById('productForm');

const productModalTitle = document.getElementById('product-modalTitle');
const productFormMethodInput = document.getElementById('product-formMethod');
const productImageLabel = document.getElementById('product-imageLabel');
const productCurrentImageSpan = document.getElementById('product-currentImage');
const productImageInput = document.getElementById('productImage');
const productSaveButton = document.getElementById('product-saveButton');

const toastContainer = document.getElementById('toast-container');

let addProductUrl = '';
let baseUpdateUrl = '';

// --- Modal Controls ---
function openModal() {
    if (!productModal || !productForm || !productModalTitle) return;

    productModalTitle.textContent = 'Add New Product';
    productForm.action = addProductUrl;
    productFormMethodInput.value = 'POST';
    productForm.reset();
    productImageLabel.textContent = 'Product Image';
    productImageInput.required = true;
    productCurrentImageSpan.textContent = '';
    productSaveButton.textContent = 'Save Product';
    productModal.classList.add('open');
    document.body.classList.add('overflow-hidden');
}

function openEditModal(product) {
    if (!productModal || !productForm || !productModalTitle) return;
    
    productModalTitle.textContent = 'Edit Product';
    productForm.action = `${baseUpdateUrl}/${product.id}`;
    productFormMethodInput.value = 'PUT';

    document.getElementById('productName').value = product.name;
    
    document.getElementById('productDescription').value = product.description || ''; 

    document.getElementById('productPrice').value = parseFloat(product.price).toFixed(2);
    document.getElementById('productStock').value = product.stock;
    document.getElementById('productCategory').value = product.category;

    productImageLabel.textContent = 'Upload New Image (Optional)';
    productImageInput.required = false;
    productImageInput.value = '';
    productCurrentImageSpan.textContent = product.image_path ? `Current: ${product.image_path.split('/').pop()}` : 'No image.';
    productSaveButton.textContent = 'Update Product';

    productModal.classList.add('open');
    document.body.classList.add('overflow-hidden');
}

window.openEditModal = openEditModal;
window.openModal = openModal;


function closeModal() {
    if (!productModal) return; 
    productModal.classList.remove('open');
    document.body.classList.remove('overflow-hidden');
}
window.closeModal = closeModal;

// --- Toast Notification Functions ---
function showToast(message, type = 'success') {
    if (!toastContainer || !message) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'toast-error' : 'toast-success'}`;

    const iconType = type === 'error' ? 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
    const iconClass = type === 'error' ? 'toast-icon-error' : 'toast-icon-success';

    toast.innerHTML = `
        <svg class="toast-icon ${iconClass}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="${iconType}"></path>
        </svg>
        <span class="toast-message">${message}</span>
        <button class="toast-close-btn" onclick="hideToast(this.parentElement)">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;

    toastContainer.appendChild(toast);

    void toast.offsetWidth;

    toast.classList.add('show');

    const timeoutId = setTimeout(() => {
        hideToast(toast);
    }, 5000);

    toast.dataset.timeoutId = timeoutId;
}

function hideToast(toastElement) {
    if (toastElement) {
        const timeoutId = toastElement.dataset.timeoutId;
        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        toastElement.classList.remove('show');
        setTimeout(() => {
            if (toastElement.parentNode) {
                toastElement.parentNode.removeChild(toastElement);
            }
        }, 300);
    }
}
window.hideToast = hideToast;


// --- Chart.js Initialization ---
function initSalesChart() {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;
     if (salesChartInstance) salesChartInstance.destroy();
    salesChartInstance = new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales (₱)',
                data: [1200, 1900, 3000, 2500, 4200, 3800, 5000],
                borderColor: 'var(--color-sakura)',
                backgroundColor: 'rgba(255, 107, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true }}, plugins: { legend: { display: false }}}
    });
}
function initProductChart() {
    const ctx = document.getElementById('productChart');
    if (!ctx) return;
     if (productChartInstance) productChartInstance.destroy();
    productChartInstance = new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Beaded Bracelets', 'Anime Keychains', 'Jewelry Boxes'],
            datasets: [{
                label: 'Sales by Category',
                data: [300, 150, 75],
                backgroundColor: ['var(--color-sakura)','var(--color-sky)','var(--color-cta)'],
                hoverOffset: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { fontFamily: 'var(--font-poppins)'}}}}
    });
}

document.addEventListener('DOMContentLoaded', () => {
      addProductUrl = document.body.dataset.addProductUrl || '';
      baseUpdateUrl = document.body.dataset.baseUpdateUrl || '';

      initSalesChart();
      initProductChart();

      const successMessage = document.body.dataset.sessionSuccess;
      const errorMessage = document.body.dataset.sessionError;

      if (successMessage) {
          showToast(successMessage, 'success');
      }
      if (errorMessage) {
          showToast(errorMessage, 'error');
      }

      if (productModal) {
        productModal.addEventListener('click', (e) => {
            if (e.target === productModal) {
                closeModal();
            }
        });
      }
});