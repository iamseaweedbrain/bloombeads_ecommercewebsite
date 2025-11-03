// public/js/payment.js

document.addEventListener("DOMContentLoaded", function() {
    
    // Get all the elements we need
    const checkoutForm = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    
    // Modal Elements
    const paymentModal = document.getElementById('payment-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const iHavePaidBtn = document.getElementById('i-have-paid-btn');

    // QR Code Content Blocks (inside the modal)
    const gcashContent = document.getElementById('gcash-qr-content');
    const mayaContent = document.getElementById('maya-qr-content');

    // Helper functions to open/close modal
    const openModal = () => paymentModal.classList.remove('hidden');
    const closeModal = () => paymentModal.classList.add('hidden');

    // --- Main Logic: "PLACE ORDER" button ---
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function(event) {
            
            // STOP the button from submitting the form by default
            event.preventDefault(); 
            
            // Find out which payment method is selected
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

            if (selectedMethod === 'cod') {
                // If COD, just submit the form right away
                checkoutForm.submit();

            } else if (selectedMethod === 'gcash') {
                // If GCash, show the GCash content and open the modal
                gcashContent.classList.remove('hidden');
                mayaContent.classList.add('hidden');
                openModal();

            } else if (selectedMethod === 'maya') {
                // If Maya, show the Maya content and open the modal
                mayaContent.classList.remove('hidden');
                gcashContent.classList.add('hidden');
                openModal();
            }
        });
    }

    // --- Modal Button Logic ---

    if (iHavePaidBtn) {
        iHavePaidBtn.addEventListener('click', function() {
            // This button now submits the form
            checkoutForm.submit();
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Backdrop click
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', closeModal);
    }

});