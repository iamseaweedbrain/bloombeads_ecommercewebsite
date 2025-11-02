/**
 * Displays a toast notification.
 * @param {string} message The message to show.
 * @param {string} type 'success' or 'error'.
 */
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer || !message) { console.warn('Toast container/message missing'); return; };

    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'toast-error' : 'toast-success'} pointer-events-auto`;
    toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
    const iconType = type === 'error' ? 'M6 18L18 6M6 6l12 12' : 'M5 13l4 4L19 7';
    const iconClass = type === 'error' ? 'toast-icon-error' : 'toast-icon-success';

    toast.innerHTML = `
        <span class="sr-only">${type === 'error' ? 'Error' : 'Success'}:</span>
        <svg class="toast-icon ${iconClass}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconType}"></path></svg>
        <span class="toast-message">${message}</span>
        <button class="toast-close-btn" onclick="hideToast(this.closest('.toast'))" aria-label="Close message">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;
    toastContainer.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    const timeoutId = setTimeout(() => { hideToast(toast); }, 5000);
    toast.dataset.timeoutId = timeoutId;
}

/**
 * Hides a toast notification.
 * @param {HTMLElement} toastElement
 */
function hideToast(toastElement) {
    if (toastElement && toastElement.classList.contains('show')) {
        const timeoutId = toastElement.dataset.timeoutId;
        if (timeoutId) clearTimeout(timeoutId);
        toastElement.classList.remove('show');
        toastElement.addEventListener('transitionend', () => { if (toastElement.parentNode) toastElement.parentNode.removeChild(toastElement); }, { once: true });
        setTimeout(() => { if (toastElement.parentNode) toastElement.parentNode.removeChild(toastElement); }, 350);
    }
}

/**
 * Updates the cart badge counter in the header.
 * @param {number} totalQuantity
 */
function updateCartBadge(totalQuantity) {
    const badge = document.getElementById('cart-badge');
    if (!badge) return;

    if (totalQuantity > 0) {
        badge.textContent = totalQuantity;
        badge.classList.remove('hidden');
    } else {
        badge.textContent = '0';
        badge.classList.add('hidden');
    }
}

window.showToast = showToast;
window.hideToast = hideToast;
window.updateCartBadge = updateCartBadge;